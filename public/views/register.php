<section class="container flex flex-col items-center justify-center h-full w-screen m-auto">
    <form method="POST" class="form w-2/3 max-w-100 mx-auto grid gap-6">
        <div role="group" class="field">
            <label for="username">Nom d'utilisateur</label>
            <input name="username" class="input" id="username" type="text" placeholder="nom.prenom" required>
        </div>

        <div role="group" class="field">
            <label for="password">Mot de passe</label>
            <input name="password" id="password" type="password" placeholder="••••••••" required>
        </div>
        <div role="group" class="field">
            <label for="vfyPassword">Confirmer le mot de passe</label>
            <input name="vfyPassword" id="vfyPassword" type="password" placeholder="••••••••" required>
        </div>
        <hr role="separator">
        <div class="flex gap-6 flex-row">
            <div role="group" class="field">
                <label for="firstname">Nom</label>
                <input name="firstname" class="input" id="firstname" type="text" placeholder="Doe" required>
            </div>

            <div role="group" class="field">
                <label for="lastname">Prénom</label>
                <input name="lastname" class="input" id="lastname" type="text" placeholder="John" required>
            </div>
        </div>
        <hr role="separator">
        <div role="group" class="field">
            <label for="code">Code d'inscription</label>
            <input name="code" id="code" type="password" placeholder="Code d'inscription" required>
            <p class="text-muted-foreground text-sm">Code fourni par le centre équestre pour permettre l'inscription d'un nouveau moniteur.</p>
        </div>
        <button type="submit" class="btn">S'inscrire</button>
        <a href="./?p=login" class="cursor-pointer text-center text-sm">J'ai déjà un compte</a>
    </form>
    <?php if (isset($error)) { ?>
        <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
            <h2>Erreur d'inscription</h2>
            <section>
                <?= $error ?>
            </section>
        </div>
    <?php } ?>
    <?php if (isset($success)) { ?>
        <div class="alert w-2/3 max-w-100 mx-auto mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
            <h2>Inscription réussie</h2>
            <section>
                <?= $success ?>
            </section>
        </div>
    <?php } ?>
</section>
