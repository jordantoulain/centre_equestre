<?php
    try {
        $connexion = new PDO($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'],  array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
        return $connexion;

    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        exit;
    }
?>
