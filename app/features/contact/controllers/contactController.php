<?php
    include_once "$root/../app/features/contact/models/contactModel.php";

    if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['subject']) && isset($_POST['message'])) {

        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("CSRF error. Try again.");
        }

        $email = trim($_POST['email']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        $nameRegex = '/^[a-zA-ZÀ-ÿ\-\s]+$/';
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (empty($email) || empty($firstname) || empty($lastname) || empty($subject) || empty($message)) {
            $error = "Tous les champs doivent être remplis.";
        } elseif (!preg_match($emailRegex, $email)) {
            $error = "L'adresse e-mail n'est pas valide.";
        } elseif (!preg_match($nameRegex, $firstname) || !preg_match($nameRegex, $lastname)) {
            $error = "Le nom et le prénom contiennent des caractères non autorisés.";
        } else {
            $send = sendMessage($email, $firstname, $lastname, $subject, $message);

            if ($send) {
                $success = "Message envoyé avec succès.";
            } else {
                $error = "Une erreur est survenue lors de l'envoi du message.";
            }
    }
    }

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";
    include_once "$root/../app/features/contact/views/contact.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>
