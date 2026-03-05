<section class="container flex flex-col items-center justify-center h-full w-screen m-auto">
    <form method="POST" class="form w-2/3 max-w-100 mx-auto grid gap-6">
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
        <article class="group/item flex items-center border border-red-400 text-sm rounded-md transition-colors [a]:hover:bg-accent/50 [a]:transition-colors duration-100 flex-wrap outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] p-4 mt-10 gap-4">
            <div class="flex flex-1 flex-col gap-1">
                <h3 class="flex w-fit text-red-400 items-center gap-2 text-sm leading-snug font-medium">Erreur de connexion</h3>
                <p class="text-muted-foreground line-clamp-2 text-sm leading-normal font-normal text-balance [&>a:hover]:text-primary [&>a]:underline [&>a]:underline-offset-4">Mot de passe ou nom d'utilisateur incorrect.</p>
            </div>
        </article>
    <?php } ?>
</section>
