<?php
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    require_once "$root/../app/features/admin/models/typeRepriseModel.php";
    
    if (isset($_POST['btnRemove']) && isset($_POST['id_type_reprise'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }
        $result = removeTypeReprise($_POST['id_type_reprise']);
    }

    if(isset($_POST['btnEdit']) && isset($_POST['id_type_reprise'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }
        $result = editTypeReprise($_POST['id_type_reprise'], $_POST['nom_type'], $_POST['id_moniteur'], $_POST['type_monture']);
    }

    if(isset($_POST['btnAdd'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF. Veuillez réessayer.");
        }
        $result = addTypeReprise($_POST['nom_type'], $_POST['id_moniteur'], $_POST['type_monture']);
    }

    $typesReprises = getAllTypesReprise();
    $moniteurs = getMoniteurs();
    $typesMontures = getTypesMontureForReprise();

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/admin/views/types_reprises.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>