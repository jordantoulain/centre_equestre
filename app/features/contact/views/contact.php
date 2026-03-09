<section class="container flex flex-col items-center justify-center h-full w-screen m-auto">
    <form method="POST" class="form w-2/3 max-w-100 mx-auto grid gap-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <div role="group" class="field">
            <label for="email">Adresse e-mail</label>
            <input name="email" class="input" id="email" type="email" placeholder="votre@email.com" required>
        </div>
        <div class="flex gap-6 flex-row">
            <div role="group" class="field">
                <label for="lastname">Nom</label>
                <input name="lastname" class="input" id="lastname" type="text" placeholder="Doe" required>
            </div>

            <div role="group" class="field">
                <label for="firstname">Prénom</label>
                <input name="firstname" class="input" id="firstname" type="text" placeholder="John" required>
            </div>
        </div>
        <hr role="separator">
        <div role="group" class="field">
            <label for="subject">Sujet</label>
            <input name="subject" class="input" id="subject" type="text" placeholder="Sujet du message" required>
        </div>
        <div role="group" class="field">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="4" placeholder="Votre message ..." aria-describedby="message-desc"></textarea>
        </div>
        <button type="submit" class="btn">Envoyer le message</button></button>
    </form>
    <?php if (isset($error)) { ?>
        <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
            <h2>Erreur d'envoi</h2>
            <section>
                <?= $error ?>
            </section>
        </div>
    <?php } ?>
    <?php if (isset($success)) { ?>
        <div class="alert w-2/3 max-w-100 mx-auto mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
            <h2>Message envoyé</h2>
            <section>
                <?= $success ?>
            </section>
        </div>
    <?php } ?>
</section>
