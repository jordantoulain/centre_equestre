<?php
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    require_once "$root/../app/features/admin/models/repriseDetailModel.php";

    $numReprise = $_GET['id'] ?? null;
    if (!$numReprise) {
        header("Location: /?p=adminReprises");
        exit();
    }

    $error_message = "";
    $success_message = "";

    if (isset($_POST['btnAssignMonture'])) {
        if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            assignMonture($numReprise, $_POST['numCavalier'], $_POST['numMonture']);
            $success_message = "Monture mise à jour.";
        }
    }

    if (isset($_POST['btnRemove'])) {
        if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            removeCavalierReprise($numReprise, $_POST['numCavalier']);
            $success_message = "Cavalier retiré de la séance.";
        }
    }

    if (isset($_POST['btnAddCavalier'])) {
        if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $numCavalier = $_POST['numCavalier'];
            $numMonture = $_POST['numMonture'];
            $methodeAjout = $_POST['hiddenMethodeAjout'] ?? ''; 

            if (empty($methodeAjout)) {
                $error_message = "Erreur technique : Méthode d'ajout non définie.";
            } else {
                $resultat = addCavalierReprise($numReprise, $numCavalier, $numMonture, $methodeAjout);
                if ($resultat === true) {
                    $success_message = "Cavalier ajouté avec succès.";
                } else {
                    $error_message = $resultat;
                }
            }
        }
    }

    $reprise = getRepriseInfos($numReprise);
    if (!$reprise) {
        die("Séance introuvable.");
    }

    $inscrits = getInscritsReprise($numReprise);
    $cavaliersDispos = getCavaliersDisponibles($numReprise);
    $montures = getMonturesDisponibles();

    // LA MODIFICATION EST ICI : Typage strict pour JavaScript
    $cavaliersJS = [];
    foreach ($cavaliersDispos as $c) {
        $cavaliersJS[$c['numCavalier']] = [
            // S'il n'y a pas de tickets (null ou vide), c'est null. Sinon on force en chiffre (int).
            'nbTickets' => ($c['nbTickets'] === null || $c['nbTickets'] === '') ? null : (int)$c['nbTickets']
        ];
    }

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/admin/views/reprise_detail.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>