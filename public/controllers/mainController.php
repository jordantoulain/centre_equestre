<?php
function returnIfLoggedIn(){
    if (isset($_SESSION['username'])){
        header("Location: ?p=home");
        exit;
    }
}

function getBreadcrumbs($action){
    $breadcrumbs = [
        "home" => ["Accueil"],
        "login" => ["Authentification", "Connexion"],
        "register" => ["Authentification","Inscription"],
        "logout" => ["Compte", "Déconnexion"]
    ];
    return $breadcrumbs[$action] ?? $breadcrumbs["home"];
}

function getControllers(){
    $actions = [
        "home" => "homeController.php",
        "login" => "loginController.php",
        "register" => "registerController.php",
        "logout" => "logoutController.php"
    ];
    return $actions;
}

function controleurPrincipal($action){

    $controllers = getControllers();

    if (array_key_exists ( $action , $controllers )){
        return $controllers[$action];
    }
    else{
        return $controllers["home"];
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($string) {
    if ($string === null) return '';
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>
