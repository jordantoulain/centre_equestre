<?php
    returnIfLoggedIn();

    include "$root/models/authModel.php";

    if (isset($_POST['username']) && isset($_POST['password'])){
        $user = login($_POST['username'], $_POST['password']);
        if ($user){
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

    include "$root/views/components/header.php";
    include "$root/views/login.php";
    include "$root/views/components/footer.php";
?>
