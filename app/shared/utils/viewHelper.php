<?php
    function e($string) {
        if ($string === null) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    function getBreadcrumbs($page){
        global $root;
        $breadcrumbs = require_once "$root/../app/shared/config/breadcrumbs.php";
        return $breadcrumbs[$page] ?? $breadcrumbs['404'];
    }

    function asset(string $entry) {
        global $root;
        if ($_ENV['APP_ENV'] == "development") {
            return "http://localhost:5173/" . $entry;
        }
        $manifestPath = "$root/build/.vite/manifest.json";
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            return isset($manifest[$entry]) ? '/build/' . $manifest[$entry]['file'] : '';
        }
        return '';
    }
?>
