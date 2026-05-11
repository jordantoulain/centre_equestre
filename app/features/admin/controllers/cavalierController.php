<?php
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    require_once "$root/../app/features/admin/models/cavalierModel.php";
    
    $success_message = "";
    $error_message = "";

    if (isset($_POST['btnRemove']) && isset($_POST['numCavalier'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF.");
        }
        $result = removeCavalier($_POST['numCavalier']);
        if ($result) {
            $success_message = "Cavalier supprimé avec succès.";
        } else {
            $error_message = "Impossible de supprimer ce cavalier. Il est probablement propriétaire d'une monture ou inscrit à des séances.";
        }
    }

    if(isset($_POST['btnEdit']) && isset($_POST['numCavalier'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF.");
        }
        $nbTickets = ($_POST['nbTickets'] === '') ? null : $_POST['nbTickets'];
        
        $result = editCavalier($_POST['numCavalier'], trim($_POST['nom']), trim($_POST['prenom']), $nbTickets, $_POST['codeTypeMonture']);
        if ($result !== false) {
            $success_message = "Cavalier modifié avec succès.";
        } else {
            $error_message = "Erreur lors de la modification.";
        }
    }

    if(isset($_POST['btnAdd'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF.");
        }
        
        $typeInscription = $_POST['type_inscription'];
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $codeTypeMonture = $_POST['codeTypeMonture'];
        
        $nbTickets = null;
        $creneaux = [];

        if ($typeInscription === 'tickets') {
            $nbTickets = !empty($_POST['nbTickets']) ? (int)$_POST['nbTickets'] : 0;
        } else if ($typeInscription === 'forfait') {
            $creneaux = $_POST['creneaux'] ?? []; 
        }

        $result = addCavalier($nom, $prenom, $nbTickets, $codeTypeMonture, $creneaux);
        
        if ($result) {
            $success_message = "Cavalier ajouté avec succès.";
        } else {
            $error_message = "Erreur lors de l'ajout du cavalier.";
        }
    }

    $cavaliers = getAllCavaliers();
    $typesMontures = getTypesMonture();
    $creneauxPlanning = getAllCreneauxForCavaliers();

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/admin/views/cavaliers.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>