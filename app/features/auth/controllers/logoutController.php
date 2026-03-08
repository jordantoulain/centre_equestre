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


        include_once "$root/../app/shared/views/components/header.php";
        include_once "$root/../app/shared/views/components/breadcrumb.php";
        include_once "$root/../app/features/auth/views/logout.php";
        include_once "$root/../app/shared/views/components/footer.php";
    }else{
        header("Location: ?p=home");
        exit;
    }
?>
