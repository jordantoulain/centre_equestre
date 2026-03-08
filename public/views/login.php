<section class="container flex flex-col items-center justify-center h-full w-screen m-auto">
    <form method="POST" class="form w-2/3 max-w-100 mx-auto grid gap-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <div role="group" class="field">
            <label for="username">Nom d'utilisateur</label>
            <input class="input" name="username" id="username" type="text" placeholder="nom.prenom" <?php echo isset($error) ? 'aria-invalid="true"' : ''; ?> required>
        </div>

        <div role="group" class="field">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" placeholder="••••••••" <?php echo isset($error) ? 'aria-invalid="true"' : ''; ?> required>
        </div>

        <button type="submit" class="btn">Se connecter</button>
        <a href="./?p=register" class="cursor-pointer text-center text-sm">Créer un compte</a>
    </form>
    <?php if (isset($error)) { ?>
        <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
            <h2>Erreur de connexion</h2>
            <section>
                Veuillez vérifier vos informations de connexion et réessayer.
            </section>
        </div>
    <?php } ?>
</section>
