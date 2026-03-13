<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre équestre</title>
    <?php if ($isDev): ?>
        <script type="module" src="http://localhost:5173/@vite/client"></script>
    <?php endif; ?>
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
    <link rel="stylesheet" href="<?= asset('src/app.css') ?>">
    <script type="module" src="<?= asset('src/index.js') ?>" defer></script>
</head>
<body class="flex flex-col min-h-screen w-screen">
<?php
    include "$root/../app/shared/views/components/navbar.php";
?>
