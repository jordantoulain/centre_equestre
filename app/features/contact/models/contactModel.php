<?php
    include_once "$root/../app/shared/config/pdo.config.php";

    function sendMessage($email, $firstname, $lastname, $subject, $message) {
        global $connexion;

        $prep = $connexion->prepare("INSERT INTO messages (email, prenom, nom, sujet, message) VALUES (?,?,?,?,?)");
        return $prep->execute([$email, $firstname, $lastname, $subject, $message]);
    }
?>
