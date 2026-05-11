<?php
include "$root/../app/shared/config/pdo.config.php";

function getAllCreneaux() {
    global $connexion;

    $query = "SELECT p.*, tr.libTypeReprise, m.nomMoniteur, m.prenomMoniteur 
              FROM planning p 
              INNER JOIN type_reprise tr ON p.codeTypeReprise = tr.codeTypeReprise
              INNER JOIN moniteur m ON tr.numMoniteur = m.numMoniteur
              ORDER BY FIELD(p.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), p.heure";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getTypesRepriseForPlanning() {
    global $connexion;

    $query = "SELECT tr.codeTypeReprise, tr.libTypeReprise, m.nomMoniteur, m.prenomMoniteur 
              FROM type_reprise tr
              INNER JOIN moniteur m ON tr.numMoniteur = m.numMoniteur";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function removeCreneau($numPlanning) {
    global $connexion;

    try {
        $query = "DELETE FROM planning WHERE numPlanning = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$numPlanning]);

        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function editCreneau($numPlanning, $jour, $heure, $codeTypeReprise) {
    global $connexion;

    try {
        $query = "UPDATE planning SET jour = ?, heure = ?, codeTypeReprise = ? WHERE numPlanning = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$jour, $heure, $codeTypeReprise, $numPlanning]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function addCreneau($jour, $heure, $codeTypeReprise) {
    global $connexion;

    try {
        $query = "INSERT INTO planning (jour, heure, codeTypeReprise) VALUES (?, ?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$jour, $heure, $codeTypeReprise]);
        
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}
?>