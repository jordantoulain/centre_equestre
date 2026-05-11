<?php
    require_once "$root/../app/features/horses/models/horsesModel.php";
    
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }


    if (isset($_POST['btnRemove']) && isset($_POST['horse_id'])){

        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }

        $result = removeHorse($_POST['horse_id']);
    }

    if(isset($_POST['btnEdit']) && isset($_POST['horse_id'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }

        $result = editHorse($_POST['horse_id'], $_POST);
    }

    if(isset($_POST['btnAdd'])){
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Erreur CSRF. Veuillez réessayer.");
        }

        $target_dir = "$root/../public/uploads/";
        $errors = [];

        $original_filename = $_FILES["horse_image"]["name"];
        $imageFileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

        $unique_id = bin2hex(random_bytes(16));
        $new_filename = $unique_id . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;

        $check = getimagesize($_FILES["horse_image"]["tmp_name"]);
        if($check === false) {
            $errors[] = "Le fichier téléchargé n'est pas une image valide.";
        }

        if ($_FILES["horse_image"]["size"] > 5242880) {
            $errors[] = "L'image est trop volumineuse (maximum 5 Mo).";
        }

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $errors[] = "Seuls les formats JPG, JPEG, PNG et WEBP sont acceptés.";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["horse_image"]["tmp_name"], $target_file)) {
                $result = addHorse($_POST, $new_filename);
            } else {
                $errors[] = "Un problème est survenu lors de l'enregistrement de l'image sur le serveur.";
            }
        }
    }

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";

    $horses = getHorses();
    $types = getTypeMonture();
    $proprietaires = getProprietaires();
    include_once "$root/../app/features/admin/views/horses.php";

    include_once "$root/../app/shared/views/components/footer.php";
?>
