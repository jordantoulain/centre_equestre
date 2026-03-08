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
        "home" => "../app/features/home/controllers/homeController.php",
        "login" => "../app/features/auth/controllers/loginController.php",
        "register" => "../app/features/auth/controllers/registerController.php",
        "logout" => "../app/features/auth/controllers/logoutController.php"
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
