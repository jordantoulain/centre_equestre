<?php
$manifestPath = __DIR__ . '/build/manifest.json';
$manifest = [];

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
}

function asset(string $entryName) {
    global $manifest;
    return isset($manifest[$entryName]) ? './build/' . basename($manifest[$entryName]) : '';
}

if(!isset($_ENV['PROD'])){
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Centre équestre</title>
    <link rel="stylesheet" href="./build/app.css?v=<?= filemtime(__DIR__ . '/build/app.css') ?>">
    <?php if (asset('src/index.js')): ?>
        <script src="<?= asset('src/index.js') ?>" defer></script>
    <?php endif; ?>
</head>
<body>
    <div id="app">
        <h1>Bienvenue au centre équestre</h1>
        <p>Découvrez nos activités et réservez votre place dès maintenant !</p>
    </div>
</body>
</html>