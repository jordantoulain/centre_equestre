<?php
    if(isset($_SESSION['username'])){

        if (isset($_POST['confirm'])){
            session_destroy();
            unset($_SESSION['username']);
            unset($_SESSION['firstname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['role']);
            header("Location: ?p=home");
            exit;
        }


        include "$root/views/components/header.php";
        include "$root/views/logout.php";
        include "$root/views/components/footer.php";
    }else{
        header("Location: ?p=home");
        exit;
    }
?>
