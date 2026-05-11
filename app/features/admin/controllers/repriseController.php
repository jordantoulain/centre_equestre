<?php
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    require_once "$root/../app/features/admin/models/repriseModel.php";
    
    if (isset($_POST['btnRemove']) && isset($_POST['numReprise'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF.");
        }
        $result = removeReprise($_POST['numReprise']);
    }

    $error_message = "";

    if(isset($_POST['btnAdd'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF.");
        }
        
        $numPlanning = $_POST['numPlanning'];
        $dateReprise = $_POST['dateReprise'];
        $jourPrevu = $_POST['jourPrevu'];

        $joursTraduits = [0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'];
        $jourDeLaDate = $joursTraduits[date('w', strtotime($dateReprise))];

        if (strtolower($jourDeLaDate) !== strtolower($jourPrevu)) {
            $error_message = "Erreur : Vous essayez de créer une séance le $jourDeLaDate alors que le créneau est un $jourPrevu.";
        } else {
            $result = addReprise($numPlanning, $dateReprise);
        }
    }

    $reprises = getAllReprises();
    $plannings = getPlanningsPourReprise();

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/admin/views/reprises.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>