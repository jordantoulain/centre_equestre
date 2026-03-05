<section class="container flex flex-col items-center justify-center h-full w-screen m-auto">
    <form class="form w-2/3 max-w-100 m-auto grid gap-6">
        <div role="group" class="field">
            <label for="username">Nom d'utilisateur</label>
            <input class="input" id="username" type="text" placeholder="nom.prenom">
        </div>

        <div role="group" class="field">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" placeholder="••••••••">
        </div>

        <button type="submit" class="btn">Se connecter</button>
        <a href="./?p=register" class="cursor-pointer text-center text-sm">Créer un compte</a>
    </form>
</section>
