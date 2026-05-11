<?php
include "$root/../app/shared/config/pdo.config.php";

function getAllCavaliers() {
    global $connexion;
    $query = "SELECT c.*, tm.libTypeMonture 
              FROM cavalier c 
              LEFT JOIN type_monture tm ON c.codeTypeMonture = tm.codeTypeMonture
              ORDER BY c.nomCavalier, c.prenomCavalier";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getTypesMonture() {
    global $connexion;
    $query = "SELECT * FROM type_monture";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function getAllCreneauxForCavaliers() {
    global $connexion;
    $query = "SELECT p.numPlanning, p.jour, p.heure, tr.libTypeReprise 
              FROM planning p
              INNER JOIN type_reprise tr ON p.codeTypeReprise = tr.codeTypeReprise
              ORDER BY FIELD(p.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), p.heure";
    $prep = $connexion->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

function removeCavalier($numCavalier) {
    global $connexion;
    try {
        $query = "DELETE FROM cavalier WHERE numCavalier = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$numCavalier]);
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function addCavalier($nom, $prenom, $nbTickets, $codeTypeMonture, $creneaux) {
    global $connexion;
    try {
        $connexion->beginTransaction();

        $query = "INSERT INTO cavalier (nomCavalier, prenomCavalier, nbTickets, codeTypeMonture) 
                  VALUES (?, ?, ?, ?)";
        $prep = $connexion->prepare($query);
        $prep->execute([
            $nom, 
            $prenom, 
            ($nbTickets === '' || $nbTickets === null) ? null : $nbTickets, 
            $codeTypeMonture
        ]);
        
        $numCavalier = $connexion->lastInsertId();

        if (!empty($creneaux) && is_array($creneaux)) {
            $uniqueCreneaux = array_unique($creneaux);
            
            $queryInscr = "INSERT INTO inscription_annuelle (numCavalier, numPlanning) VALUES (?, ?)";
            $prepInscr = $connexion->prepare($queryInscr);
            
            foreach ($uniqueCreneaux as $numPlanning) {
                $prepInscr->execute([$numCavalier, $numPlanning]);
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

function editCavalier($numCavalier, $nom, $prenom, $nbTickets, $codeTypeMonture) {
    global $connexion;
    try {
        $query = "UPDATE cavalier SET nomCavalier = ?, prenomCavalier = ?, nbTickets = ?, codeTypeMonture = ? WHERE numCavalier = ?";
        $prep = $connexion->prepare($query);
        $prep->execute([$nom, $prenom, $nbTickets, $codeTypeMonture, $numCavalier]);
        return $prep->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}
?>