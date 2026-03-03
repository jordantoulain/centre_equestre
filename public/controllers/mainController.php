<?php
function controleurPrincipal($calledAction){
    $action = $calledAction;
    $controllers = array();
    $controllers["home"] = "homeController.php";
    $controllers["login"] = "loginController.php";

    if (array_key_exists ( $action , $controllers )){
        return $controllers[$action];
    }
    else{
        return $controllers["home"];
    }
}
?>
