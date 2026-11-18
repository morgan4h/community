<?php
$catalogPath = __DIR__ . '/data/catalog.json';
$raw         = is_file($catalogPath) ? file_get_contents($catalogPath) : '[]';
$catalog     = json_decode($raw, true) ?? [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#07090f">
  <meta name="description" content="TMK Community — watch movies together, any distance.">
  <title>TMK Community — Watch Together</title>

  <!-- Typeface -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/netflix.css">

  <!-- Catalog injected server-side; no extra request needed -->
  <script>window.TMK_CATALOG = <?= json_encode($catalog, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) ?>;</script>
</head>
<body>
  <header class="topbar">
    <a class="brand" href="#" data-action="home" aria-label="TMK Community home">
      <span class="brand-mark">TMK</span>
      <span>TMK COMMUNITY</span>
    </a>
    <div class="topbar-right">
      <span class="status-pill"><i></i> PRIVATE SCREEN</span>
      <button class="text-button hidden" id="logoutButton" type="button">Sign out</button>
    </div>
  </header>

  <main id="app" class="app-shell" aria-live="polite" aria-atomic="false"></main>

  <footer class="site-footer">
    Watch together. <span>·</span> TMK Community
  </footer>

  <script src="assets/js/app.js" defer></script>
</body>
</html>
