<?php
include "$root/../app/shared/config/pdo.config.php";

function getAllTypesReprise() {
    global $connexion;

    $query = "SELECT tr.*, m.nomMoniteur, m.prenomMoniteur, tm.libTypeMonture 
              FROM type_reprise tr 
              LEFT JOIN moniteur m ON tr.numMoniteur = m.numMoniteur
              LEFT JOIN type_monture tm ON tr.codeTypeMonture = tm.codeTypeMonture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getMoniteurs() {
    global $connexion;

    $query = "SELECT numMoniteur, nomMoniteur, prenomMoniteur FROM moniteur";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getTypesMontureForReprise() {
    global $connexion;

    $query = "SELECT * FROM type_monture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function removeTypeReprise($id) {
    global $connexion;

    try {
        $query = "DELETE FROM type_reprise WHERE codeTypeReprise = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$id]);

        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function editTypeReprise($id, $nom_type, $id_moniteur, $type_monture) {
    global $connexion;

    try {
        $query = "UPDATE type_reprise 
                  SET libTypeReprise = ?, numMoniteur = ?, codeTypeMonture = ? 
                  WHERE codeTypeReprise = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$nom_type, $id_moniteur, $type_monture, $id]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function addTypeReprise($nom_type, $id_moniteur, $type_monture) {
    global $connexion;

    try {
        $query = "INSERT INTO type_reprise (libTypeReprise, numMoniteur, codeTypeMonture) 
                  VALUES (?, ?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$nom_type, $id_moniteur, $type_monture]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}
?>