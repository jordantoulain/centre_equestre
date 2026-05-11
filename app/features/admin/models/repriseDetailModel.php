<?php
include "$root/../app/shared/config/pdo.config.php";

function getRepriseInfos($numReprise) {
    global $connexion;
    $query = "SELECT r.numReprise, r.dateReprise, p.jour, p.heure, tr.libTypeReprise, tr.codeTypeMonture, m.nomMoniteur, m.prenomMoniteur 
              FROM reprise r
              INNER JOIN planning p ON r.numPlanning = p.numPlanning
              INNER JOIN type_reprise tr ON p.codeTypeReprise = tr.codeTypeReprise
              INNER JOIN moniteur m ON tr.numMoniteur = m.numMoniteur
              WHERE r.numReprise = ?";
    $prep = $connexion->prepare($query);
    $prep->execute([$numReprise]);
    return $prep->fetch();
}

function getInscritsReprise($numReprise) {
    global $connexion;
    $query = "SELECT ir.numCavalier, ir.numMonture, ir.rattrapage, c.nomCavalier, c.prenomCavalier, c.nbTickets, m.nomMonture,
              (SELECT COUNT(*) FROM inscription_annuelle ia WHERE ia.numCavalier = c.numCavalier) as hasForfait
              FROM inscription_reprise ir
              INNER JOIN cavalier c ON ir.numCavalier = c.numCavalier
              LEFT JOIN monture m ON ir.numMonture = m.numMonture
              WHERE ir.numReprise = ?
              ORDER BY c.nomCavalier, c.prenomCavalier";
    $prep = $connexion->prepare($query);
    $prep->execute([$numReprise]);
    return $prep->fetchAll();
}

function getCavaliersDisponibles($numReprise) {
    global $connexion;
    $query = "SELECT c.numCavalier, c.nomCavalier, c.prenomCavalier, c.nbTickets,
              (SELECT COUNT(*) FROM inscription_annuelle ia WHERE ia.numCavalier = c.numCavalier) as hasForfait
              FROM cavalier c 
              WHERE c.numCavalier NOT IN (SELECT numCavalier FROM inscription_reprise WHERE numReprise = ?)
              ORDER BY c.nomCavalier, c.prenomCavalier";
    $prep = $connexion->prepare($query);
    $prep->execute([$numReprise]);
    return $prep->fetchAll();
}

function getMonturesDisponibles() {
    global $connexion;
    $query = "SELECT numMonture, nomMonture FROM monture ORDER BY nomMonture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function assignMonture($numReprise, $numCavalier, $numMonture) {
    global $connexion;
    try {
        $numMonture = empty($numMonture) ? null : $numMonture;
        $query = "UPDATE inscription_reprise SET numMonture = ? WHERE numReprise = ? AND numCavalier = ?";
        $prep = $connexion->prepare($query);
        return $prep->execute([$numMonture, $numReprise, $numCavalier]);
    } catch (PDOException $e) {
        return false;
    }
}

function removeCavalierReprise($numReprise, $numCavalier) {
    global $connexion;
    try {
        $query = "DELETE FROM inscription_reprise WHERE numReprise = ? AND numCavalier = ?";
        $prep = $connexion->prepare($query);
        return $prep->execute([$numReprise, $numCavalier]);
    } catch (PDOException $e) {
        return false;
    }
}

function addCavalierReprise($numReprise, $numCavalier, $numMonture, $methodeAjout) {
    global $connexion;
    try {
        $connexion->beginTransaction();

        $numMonture = empty($numMonture) ? null : $numMonture;
        $isRattrapage = ($methodeAjout === 'rattrapage') ? 1 : 0;

        if ($methodeAjout === 'ticket') {
            $queryTicket = "UPDATE cavalier SET nbTickets = nbTickets - 1 WHERE numCavalier = ? AND nbTickets > 0";
            $prepTicket = $connexion->prepare($queryTicket);
            $prepTicket->execute([$numCavalier]);
            
            if ($prepTicket->rowCount() === 0) {
                $connexion->rollBack();
                return "Erreur : Ce cavalier n'a plus de tickets disponibles.";
            }
        }

        $query = "INSERT INTO inscription_reprise (numReprise, numCavalier, numMonture, rattrapage, absent) VALUES (?, ?, ?, ?, 0)";
        $prep = $connexion->prepare($query);
        $prep->execute([$numReprise, $numCavalier, $numMonture, $isRattrapage]);

        $connexion->commit();
        return true;
    } catch (PDOException $e) {
        $connexion->rollBack();
        return "Erreur SQL lors de l'ajout.";
    }
}
?>