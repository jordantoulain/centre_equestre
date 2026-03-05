<?php
include "pdo.config.php";

function login($username, $password){
    global $connexion;

    $query = "SELECT * FROM connexion WHERE login = :login";
    $prep = $connexion->prepare($query);
    $prep->bindParam(':login', $username);
    $prep->execute();
    $user = $prep->fetch();

    if ($user && password_verify($password, $user['mdp'])) {
        return $user;
    } else {
        return false;
    }
}

?>
