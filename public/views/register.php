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
        <div role="group" class="field">
            <label for="vfyPassword">Confirmer le mot de passe</label>
            <input id="vfyPassword" type="password" placeholder="••••••••">
        </div>
        <hr role="separator">
        <div class="flex gap-6 flex-row">
            <div role="group" class="field">
                <label for="firstname">Nom</label>
                <input class="input" id="firstname" type="text" placeholder="Doe">
            </div>

            <div role="group" class="field">
                <label for="lastname">Prénom</label>
                <input class="input" id="lastname" type="text" placeholder="John">
            </div>
        </div>
        <hr role="separator">
        <div role="group" class="field">
            <label for="code">Code d'inscription</label>
            <input id="code" type="password" placeholder="Code d'inscription">
            <p class="text-muted-foreground text-sm">Code fourni par le centre équestre pour permettre l'inscription d'un nouveau moniteur.</p>
        </div>
        <button type="submit" class="btn">S'inscrire</button>
    </form>
</section>
