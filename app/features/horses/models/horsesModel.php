<?php
    include "$root/../app/shared/config/pdo.config.php";

    function getHorses(){
        global $connexion;

        $query = "SELECT * FROM monture LEFT JOIN cavalier ON cavalier.numCavalier = monture.numProprietaire";
        $prep = $connexion->prepare($query);
        $prep->execute();
        $horses = $prep->fetchAll();

        return $horses;
    }
?>
