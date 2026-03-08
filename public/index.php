<?php
    $root = dirname(__FILE__);

    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if(empty($_ENV['APP_ENV'])){
        function loadEnv($path) {
            if (!file_exists($path)) return;
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                list($name, $value) = explode('=', $line, 2);
                $_ENV[trim($name)] = trim($value);
            }
        }

        loadEnv ("$root/../.env");
    }

    require_once "$root/../app/shared/utils/viewHelper.php";
    require_once "$root/../app/shared/utils/authHelper.php";
    $routes = require_once "$root/../app/shared/config/routes.php";
    $page = $_GET['p'] ?? 'home';
    $breadcrumbs = getBreadcrumbs($page);

    if (array_key_exists($page, $routes)) {
        require_once $routes[$page];
    } else {
        http_response_code(404);
        require_once $routes["404"];
    }

?>
