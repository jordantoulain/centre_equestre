<?php
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    require_once "$root/../app/features/admin/models/planningModel.php";
    
    if (isset($_POST['btnRemove']) && isset($_POST['numPlanning'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF. Veuillez réessayer.");
        }
        $result = removeCreneau($_POST['numPlanning']);
    }

    if(isset($_POST['btnEdit']) && isset($_POST['numPlanning'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF. Veuillez réessayer.");
        }
        $result = editCreneau($_POST['numPlanning'], $_POST['jour'], $_POST['heure'], $_POST['codeTypeReprise']);
    }

    if(isset($_POST['btnAdd'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF. Veuillez réessayer.");
        }
        $result = addCreneau($_POST['jour'], $_POST['heure'], $_POST['codeTypeReprise']);
    }

    $creneaux = getAllCreneaux();
    $typesReprises = getTypesRepriseForPlanning();

    $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/admin/views/planning.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>