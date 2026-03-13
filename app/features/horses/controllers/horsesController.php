<?php
    require_once "$root/../app/features/horses/models/horsesModel.php";

    $horses = getHorses();

    include_once "$root/../app/shared/views/components/header.php";
    include_once "$root/../app/features/horses/views/horses.php";
    include_once "$root/../app/shared/views/components/footer.php";
?>
