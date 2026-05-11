<?php    
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: ./");
        exit();
    }

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/shared/views/components/breadcrumb.php";

    include_once "$root/../app/features/admin/views/admin.php";

    // include_once "$root/../app/shared/views/components/footer.php";
?>
