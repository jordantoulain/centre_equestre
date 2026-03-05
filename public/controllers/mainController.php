<?php
function getBreadcrumbs($action){
    $breadcrumbs = [
        "home" => ["Accueil"],
        "login" => ["Authentification", "Connexion"],
        "register" => ["Authentification","Inscription"]
    ];
    return $breadcrumbs[$action] ?? $breadcrumbs["home"];
}

function getControllers(){
    return [
        "home" => "homeController.php",
        "login" => "loginController.php",
        "register" => "registerController.php"
    ];
}

function controleurPrincipal($calledAction){

    $action = $calledAction;
    $controllers = getControllers();

    if (array_key_exists ( $action , $controllers )){
        return $controllers[$action];
    }
    else{
        return $controllers["home"];
    }
}

?>
