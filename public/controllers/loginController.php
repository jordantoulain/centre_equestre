<?php
    returnIfLoggedIn();

    include "$root/models/authModel.php";

    if (isset($_POST['username']) && isset($_POST['password'])){
        $user = login($_POST['username'], $_POST['password']);
        if ($user){
            $_SESSION['username'] = $user['login'];
            $_SESSION['firstname'] = $user['prenom'];
            $_SESSION['lastname'] = $user['nom'];
            $_SESSION['role'] = $user['role'];
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
