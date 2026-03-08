<?php
    function returnIfLoggedIn(){
        if (isset($_SESSION['username'])){
            header("Location: ?p=home");
            exit;
        }
    }
?>
