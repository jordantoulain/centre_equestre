<?php

session_start();
$root = dirname(__FILE__);
$manifestPath = __DIR__ . '/dist/manifest.json';
$manifest = [];

if(empty($_ENV['APP_ENV'])){
    function loadEnv($path) {
        if (!file_exists($path)) return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }

    loadEnv(__DIR__ . '/../.env');
}


function asset(string $entry) {
    if ($_ENV['APP_ENV'] == "development") {
        return "http://localhost:5173/" . $entry;
    }
    $manifestPath = __DIR__ . '/build/.vite/manifest.json';
    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        return isset($manifest[$entry]) ? '/build/' . $manifest[$entry]['file'] : '';
    }
    return '';
}

include "$root/../app/features/home/controllers/mainController.php";
if (isset($_GET["p"])){
    $action = $_GET["p"];
}else{
    $action = "home";
}
$breadcrumbs = getBreadcrumbs($action);
$fichier = controleurPrincipal($action);
include "$root/$fichier";

?>
