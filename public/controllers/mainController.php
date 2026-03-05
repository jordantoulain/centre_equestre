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
        "register" => ["Authentification","Inscription"]
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

?>
