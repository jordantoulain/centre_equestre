<?php
    returnIfLoggedIn();

    include "$root/models/authModel.php";

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['vfyPassword']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['code'])){
        if ($_POST['password'] == $_POST['vfyPassword']){
            $expectedCode = $_ENV['REGISTRATION_CODE'] ?? '';
            if ($_POST['code'] == $expectedCode){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];

                $register = register($username, $password, $firstname, $lastname);
                if ($register){
                    $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                }
                else{
                    $error = "Le nom d'utilisateur est déjà pris.";
                }
            } else {
                $error = "Code d'inscription invalide.";
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    }

    include "$root/views/components/header.php";
    include "$root/views/register.php";
    include "$root/views/components/footer.php";
?>
