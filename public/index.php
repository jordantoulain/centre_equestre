<?php
session_start();
$root = dirname(__FILE__);
$manifestPath = __DIR__ . '/dist/manifest.json';
$manifest = [];

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
}

function asset(string $entryName) {
    global $manifest;
    return isset($manifest[$entryName]) ? './dist/' . basename($manifest[$entryName]) : '';
}

if(!isset($_ENV['PROD'])){
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

include "$root/controllers/mainController.php";
if (isset($_GET["p"])){
    $action = $_GET["p"];
}else{
    $action = "home";
}

$breadcrumbs = getBreadcrumbs($action);
$fichier = controleurPrincipal($action);
include "$root/controllers/$fichier";

?>
