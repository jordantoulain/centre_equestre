<?php
include "$root/../app/shared/config/pdo.config.php";

function getHorses(){
    global $connexion;

    $query = "SELECT * FROM monture LEFT JOIN cavalier ON cavalier.numCavalier = monture.numProprietaire LEFT JOIN type_monture ON type_monture.codeTypeMonture = monture.codeTypeMonture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    $horses = $prep->fetchAll();

    return $horses;
}

function getTypeMonture(){
    global $connexion;

    $query = "SELECT * FROM type_monture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    $types = $prep->fetchAll();

    return $types;
}

function getProprietaires(){
    global $connexion;

    $query = "SELECT * FROM cavalier";
    $prep = $connexion->prepare($query);
    $prep->execute();
    $proprietaires = $prep->fetchAll();

    return $proprietaires;
}

function removeHorse($horse_id){
    global $connexion;

    try {
        $query = "DELETE FROM monture WHERE numMonture = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$horse_id]);

        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function editHorse($horse_id, $horse){
    global $connexion;

    try {
        $query = "UPDATE monture SET nomMonture = ?, race = ?, robe = ?, codeTypeMonture = ?, sexe = ?, poids = ?, taille = ?, numProprietaire = ? WHERE numMonture = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$horse["horse_name"], $horse["horse_race"], $horse["horse_robe"], $horse["horse_type"], $horse["horse_sex"], $horse["horse_poids"], $horse["horse_taille"], empty($horse["horse_owner"]) ? null : $horse["horse_owner"], $horse_id]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function addHorse($horse, $image){
    global $connexion;

    try {
        $query = "INSERT INTO monture (nomMonture, race, robe, codeTypeMonture, sexe, poids, taille, numProprietaire, photoMonture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$horse["horse_name"], $horse["horse_race"], $horse["horse_robe"], $horse["horse_type"], $horse["horse_sex"], $horse["horse_poids"], $horse["horse_taille"], empty($horse["horse_owner"]) ? null : $horse["horse_owner"], $image]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}
?>
