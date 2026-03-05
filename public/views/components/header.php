<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre équestre</title>
    <script>
    (() => {
        try {
        const stored = localStorage.getItem('themeMode');
        if (stored ? stored === 'dark'
                    : matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        } catch (_) {}

        const apply = dark => {
        document.documentElement.classList.toggle('dark', dark);
        try { localStorage.setItem('themeMode', dark ? 'dark' : 'light'); } catch (_) {}
        };

        document.addEventListener('basecoat:theme', (event) => {
        const mode = event.detail?.mode;
        apply(mode === 'dark' ? true
                : mode === 'light' ? false
                : !document.documentElement.classList.contains('dark'));
        });
    })();
    </script>
    <link rel="stylesheet" href="<?= asset('.tmp/app.css') ?>">
    <script src="<?= asset('src/index.js') ?>" defer></script>
</head>
<body class="flex flex-col min-h-screen w-screen h-screen">
<?php
    include "$root/views/components/navbar.php";
    include "$root/views/components/breadcrumb.php";
?>
