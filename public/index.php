<?php
$manifestPath = __DIR__ . '/dist/manifest.json';
$manifest = [];

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
}

function asset(string $entryName) {
    global $manifest;
    return isset($manifest[$entryName]) ? './dist/' . basename($manifest[$entryName]) : '';
}

if(!isset($_ENV['PROD'])){
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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
    <?php if (asset('src/index.js')): ?>
        <script src="<?= asset('src/index.js') ?>" defer></script>
    <?php endif; ?>
    </head>
<body>
    <nav class="fixed flex p-5 w-screen">
        <div class="gap-2 hidden sm:flex">
            <a href="#" class="btn-ghost">Accueil</a>
            <a href="#" class="btn-ghost">Présentation</a>
            <a href="#" class="btn-ghost">Montures</a>
        </div>
        <div class="ml-auto gap-2 hidden sm:flex">
            <button
                type="button"
                data-tooltip="Mode sombre/clair"
                data-side="bottom"
                onclick="document.dispatchEvent(new CustomEvent('basecoat:theme'))"
                class="btn-icon-outline"
                >
                <span class="hidden dark:block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4" /><path d="M12 2v2" /><path d="M12 20v2" /><path d="m4.93 4.93 1.41 1.41" /><path d="m17.66 17.66 1.41 1.41" /><path d="M2 12h2" /><path d="M20 12h2" /><path d="m6.34 17.66-1.41 1.41" /><path d="m19.07 4.93-1.41 1.41" /></svg></span>
                <span class="block dark:hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" /></svg></span>
            </button>
            <a href="#" class="btn-primary">
                <svg class="hidden dark:block" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24"><path fill="#000000" d="M3 11h9.586l-3.5-3.5L10.5 6.086L16.414 12L10.5 17.914L9.086 16.5l3.5-3.5H3v-2Zm11 8.5h5v-15h-5v-2h7v19h-7v-2Z"/></svg>
                <svg class="block dark:hidden" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24"><path fill="#ffffff" d="M3 11h9.586l-3.5-3.5L10.5 6.086L16.414 12L10.5 17.914L9.086 16.5l3.5-3.5H3v-2Zm11 8.5h5v-15h-5v-2h7v19h-7v-2Z"/></svg>
                <span>Connexion</span>
            </a>
        </div>
    </nav>
    <div id="app" class="flex flex-col items-center justify-center h-screen w-screen dark:bg-neutral-900">

    </div>
</body>
</html>
