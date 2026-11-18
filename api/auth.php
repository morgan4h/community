<?php
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

session_start();

$usersPath = dirname(__DIR__) . '/data/users.json';

function respond(array $payload, int $status = 200): never {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function readUsers(string $path): array {
    if (!is_file($path)) return [];
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function writeUsers(string $path, array $users): void {
    $directory = dirname($path);
    if (!is_dir($directory)) mkdir($directory, 0755, true);
    $temporary = $path . '.tmp';
    if (file_put_contents($temporary, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL, LOCK_EX) === false) {
        respond(['ok' => false, 'error' => 'Unable to save account data.'], 500);
    }
    if (!rename($temporary, $path)) {
        respond(['ok' => false, 'error' => 'Unable to finalize account data.'], 500);
    }
}

function currentUser(): ?array {
    if (empty($_SESSION['user'])) return null;
    return [
        'id' => $_SESSION['user']['id'],
        'name' => $_SESSION['user']['name'],
        'email' => $_SESSION['user']['email']
    ];
}

$action = $_GET['action'] ?? '';

if ($action === 'me') {
    $user = currentUser();
    respond(['ok' => true, 'authenticated' => $user !== null, 'user' => $user]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode((string) file_get_contents('php://input'), true);
    if (!is_array($body)) $body = $_POST;
    $action = $body['action'] ?? $action;
}

if ($action === 'challenge') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(['ok' => false, 'error' => 'Method not allowed.'], 405);
    $seed = random_int(0, 5);
    $targetIndex = 2 + ($seed % 5);
    $_SESSION['challenge'] = [
        'id' => bin2hex(random_bytes(16)),
        'seed' => $seed,
        'targetIndex' => $targetIndex,
        'createdAt' => time()
    ];
    respond([
        'ok' => true,
        'challengeId' => $_SESSION['challenge']['id'],
        'seed' => $seed,
        'targetIndex' => $targetIndex
    ]);
}

if ($action === 'verify-human') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(['ok' => false, 'error' => 'Method not allowed.'], 405);
    $challengeId = (string) ($body['challengeId'] ?? '');
    $selectedIndex = filter_var($body['selectedIndex'] ?? null, FILTER_VALIDATE_INT);
    $challenge = $_SESSION['challenge'] ?? null;

    if (!$challenge || !hash_equals($challenge['id'], $challengeId)) {
        respond(['ok' => false, 'error' => 'This verification has expired. Please try again.'], 400);
    }
    if (time() - $challenge['createdAt'] > 300) {
        unset($_SESSION['challenge']);
        respond(['ok' => false, 'error' => 'This verification has expired. Please try again.'], 400);
    }
    if ($selectedIndex !== $challenge['targetIndex']) {
        respond(['ok' => false, 'error' => 'That is not the matching tile.'], 403);
    }

    $_SESSION['humanVerified'] = true;
    $_SESSION['humanVerifiedAt'] = time();
    unset($_SESSION['challenge']);
    respond(['ok' => true, 'verified' => true]);
}

if ($action === 'signup') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(['ok' => false, 'error' => 'Method not allowed.'], 405);
    if (empty($_SESSION['humanVerified']) || time() - ($_SESSION['humanVerifiedAt'] ?? 0) > 600) {
        respond(['ok' => false, 'error' => 'Complete human verification before creating an account.'], 403);
    }

    $name = trim((string) ($body['name'] ?? ''));
    $email = strtolower(trim((string) ($body['email'] ?? '')));
    $password = (string) ($body['password'] ?? '');

    if (strlen($name) < 2 || strlen($name) > 30) respond(['ok' => false, 'error' => 'Name must contain 2 to 30 characters.'], 422);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 160) respond(['ok' => false, 'error' => 'Enter a valid email address.'], 422);
    if (strlen($password) < 8) respond(['ok' => false, 'error' => 'Password must contain at least 8 characters.'], 422);

    $users = readUsers($usersPath);
    foreach ($users as $existing) {
        if (hash_equals(strtolower((string) ($existing['email'] ?? '')), $email)) {
            respond(['ok' => false, 'error' => 'An account with that email already exists.'], 409);
        }
    }

    $id = bin2hex(random_bytes(16));
    $users[] = [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'passwordHash' => password_hash($password, PASSWORD_DEFAULT),
        'createdAt' => gmdate('c'),
        'lastLoginAt' => null
    ];
    writeUsers($usersPath, $users);

    $_SESSION['user'] = ['id' => $id, 'name' => $name, 'email' => $email];
    unset($_SESSION['humanVerified'], $_SESSION['humanVerifiedAt']);
    respond(['ok' => true, 'user' => currentUser()]);
}

if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(['ok' => false, 'error' => 'Method not allowed.'], 405);
    if (empty($_SESSION['humanVerified']) || time() - ($_SESSION['humanVerifiedAt'] ?? 0) > 600) {
        respond(['ok' => false, 'error' => 'Complete human verification before signing in.'], 403);
    }

    $email = strtolower(trim((string) ($body['email'] ?? '')));
    $password = (string) ($body['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        respond(['ok' => false, 'error' => 'Email or password is incorrect.'], 401);
    }

    $users = readUsers($usersPath);
    $matchedIndex = null;
    foreach ($users as $index => $existing) {
        if (hash_equals(strtolower((string) ($existing['email'] ?? '')), $email)) {
            $matchedIndex = $index;
            break;
        }
    }

    if ($matchedIndex === null || !password_verify($password, (string) ($users[$matchedIndex]['passwordHash'] ?? ''))) {
        respond(['ok' => false, 'error' => 'Email or password is incorrect.'], 401);
    }

    $users[$matchedIndex]['lastLoginAt'] = gmdate('c');
    writeUsers($usersPath, $users);

    $matched = $users[$matchedIndex];
    session_regenerate_id(true);
    $_SESSION['user'] = ['id' => $matched['id'], 'name' => $matched['name'], 'email' => $matched['email']];
    unset($_SESSION['humanVerified'], $_SESSION['humanVerifiedAt']);
    respond(['ok' => true, 'user' => currentUser()]);
}

if ($action === 'logout') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(['ok' => false, 'error' => 'Method not allowed.'], 405);
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    respond(['ok' => true]);
}

respond(['ok' => false, 'error' => 'Unknown API action.'], 404);
