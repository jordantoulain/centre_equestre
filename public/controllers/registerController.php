<?php
    returnIfLoggedIn();

    include "$root/models/authModel.php";

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['vfyPassword']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['code'])){

        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }

        $username = trim($_POST['username']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $code = trim($_POST['code']);
        $password = $_POST['password'];
        $vfyPassword = $_POST['vfyPassword'];

        $nameRegex = '/^[a-zA-ZÀ-ÿ\-\s]+$/';
        $usernameRegex = '/^[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*$/';
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/';

        if (empty($username) || empty($firstname) || empty($lastname)) {
            $error = "Tous les champs doivent être remplis.";
        } elseif (!preg_match($usernameRegex, $username)) {
            $error = "Le nom d'utilisateur ne doit contenir que des lettres, des chiffres et des underscores.";
        } elseif (!preg_match($nameRegex, $firstname) || !preg_match($nameRegex, $lastname)) {
            $error = "Le nom et le prénom contiennent des caractères non autorisés.";
        } elseif (!preg_match($passwordRegex, $password)) {
            $error = "Le mot de passe doit faire au moins 12 caractères et inclure une majuscule, une minuscule, un chiffre et un caractère spécial.";
        } elseif ($password !== $vfyPassword) {
            $error = "Les mots de passe ne correspondent pas.";
        } else {
            $expectedCode = $_ENV['REGISTRATION_CODE'] ?? 'DEFAULT';

            if (hash_equals($expectedCode, $code)) {
                $register = register($username, $password, $firstname, $lastname);

                if ($register) {
                    $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                } else {
                    $error = "Le nom d'utilisateur est déjà pris.";
                }
            } else {
                $error = "Code d'inscription invalide.";
            }
    }
    }

    include "$root/views/components/header.php";
    include "$root/views/register.php";
    include "$root/views/components/footer.php";
?>
