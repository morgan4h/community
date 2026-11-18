<?php
/**
 * api/catalog.php
 * Returns the full movie catalogue as JSON.
 * GET  /api/catalog.php
 */
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=300');

$path = dirname(__DIR__) . '/data/catalog.json';

if (!is_file($path)) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Catalogue not found.']);
    exit;
}

$data = file_get_contents($path);
$catalog = json_decode($data, true);

if (!is_array($catalog)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Catalogue data is invalid.']);
    exit;
}

echo json_encode([
    'ok'      => true,
    'catalog' => $catalog,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
