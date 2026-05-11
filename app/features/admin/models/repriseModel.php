<?php
include "$root/../app/shared/config/pdo.config.php";

function getAllReprises() {
    global $connexion;
    $query = "SELECT r.numReprise, r.dateReprise, p.jour, p.heure, tr.libTypeReprise, m.nomMoniteur, m.prenomMoniteur 
              FROM reprise r
              INNER JOIN planning p ON r.numPlanning = p.numPlanning
              INNER JOIN type_reprise tr ON p.codeTypeReprise = tr.codeTypeReprise
              INNER JOIN moniteur m ON tr.numMoniteur = m.numMoniteur
              ORDER BY r.dateReprise DESC, p.heure ASC";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getPlanningsPourReprise() {
    global $connexion;
    $query = "SELECT p.numPlanning, p.jour, p.heure, tr.libTypeReprise, m.nomMoniteur 
              FROM planning p
              INNER JOIN type_reprise tr ON p.codeTypeReprise = tr.codeTypeReprise
              INNER JOIN moniteur m ON tr.numMoniteur = m.numMoniteur
              ORDER BY FIELD(p.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), p.heure";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function addReprise($numPlanning, $dateReprise) {
    global $connexion;
    try {
        $connexion->beginTransaction();

        $query = "INSERT INTO reprise (numPlanning, dateReprise) VALUES (?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([$numPlanning, $dateReprise]);
        
        $numReprise = $connexion->lastInsertId();

        $queryForfait = "SELECT numCavalier FROM inscription_annuelle WHERE numPlanning = ?";
        $prepForfait = $connexion->prepare($queryForfait);
        $prepForfait->execute([$numPlanning]);
        $cavaliersForfait = $prepForfait->fetchAll();

        if (!empty($cavaliersForfait)) {
            $queryInscr = "INSERT INTO inscription_reprise (numReprise, numCavalier, numMonture, rattrapage, absent) VALUES (?, ?, 0, 0, 0)";
            $prepInscr = $connexion->prepare($queryInscr);
            foreach ($cavaliersForfait as $cav) {
                $prepInscr->execute([$numReprise, $cav['numCavalier']]);
            }
        }

        $connexion->commit();
        return true;
    } catch (PDOException $e) {
        $connexion->rollBack();
        print($e->getMessage());
        return false;
    }
}

function removeReprise($numReprise) {
    global $connexion;
    try {
        $query = "DELETE FROM reprise WHERE numReprise = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$numReprise]);
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}
?>