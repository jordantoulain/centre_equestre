<?php
include "$root/../app/shared/config/pdo.config.php";

function login($username, $password){
    global $connexion;

    $query = "SELECT * FROM connexion WHERE login = ?";
    $prep = $connexion->prepare($query);
    $prep->execute([$username]);
    $user = $prep->fetch();

    if (!$user) {
        return false;
    }

    $query = "SELECT * FROM moniteur WHERE numMoniteur = ?";
    $prep = $connexion->prepare($query);
    $prep->execute([$user['numMoniteur']]);
    $moniteur = $prep->fetch();

    if ($user && $moniteur && password_verify($password, $user['mdp'])) {
        return [$user, $moniteur];
    } else {
        return false;
    }
}

function register($username, $password, $firstname, $lastname){
    global $connexion;

    $query = "SELECT * FROM connexion WHERE login = ?";
    $prep = $connexion->prepare($query);
    $prep->execute([$username]);
    if ($prep->fetch()) {
        return false;
    }

    try {
        $connexion->beginTransaction();

        $query = "INSERT INTO moniteur (nomMoniteur, prenomMoniteur) VALUES (?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$lastname, $firstname]);
        $numMoniteur = $connexion->lastInsertId();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO connexion (login, mdp, numMoniteur) VALUES (?, ?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$username, $hashedPassword, $numMoniteur]);

        $connexion->commit();
        return true;
    } catch (Exception $e) {
        $connexion->rollBack();
        return false;
    }
}

?>
