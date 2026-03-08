<?php
    returnIfLoggedIn();

    include "$root/../app/features/auth/models/authModel.php";

    if (isset($_POST['username']) && isset($_POST['password'])){

        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }

        $user = login($_POST['username'], $_POST['password']);
        if ($user){
            session_regenerate_id(true);
            $_SESSION['username'] = $user[0]['login'];
            $_SESSION['firstname'] = $user[1]['prenomMoniteur'];
            $_SESSION['lastname'] = $user[1]['nomMoniteur'];
            $_SESSION['role'] = $user[0]['role'];
            header("Location: ?p=home");
            exit;
        }
        else{
            $error = "Identifiants invalides.";
        }
    }

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/auth/views/login.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>
