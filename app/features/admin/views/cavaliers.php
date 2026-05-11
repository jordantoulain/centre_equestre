<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    <h1 class="text-4xl font-bold text-center mb-2">Gestion des Cavaliers</h1>
    <p class="text-muted-foreground text-center mb-10">Gérez les inscriptions des cavaliers, qu'ils soient au forfait annuel ou avec un système de tickets.</p>

    <?php if(!empty($error_message)): ?>
        <div class="alert-destructive w-2/3 max-w-100 mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
            <h2>Action refusée</h2>
            <section><?= htmlspecialchars($error_message) ?></section>
        </div>
    <?php endif; ?>

    <?php if(!empty($success_message)): ?>
        <div class="alert w-2/3 max-w-100 mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
            <h2>Succès</h2>
            <section><?= htmlspecialchars($success_message) ?></section>
        </div>
    <?php endif; ?>

    <button class="btn-ghost ml-auto mb-3" onclick="document.getElementById('add-cavalier').showModal()">
        <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g opacity=0.4><path d="M8 12H16"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M12 16V8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></svg>
        Nouveau cavalier
    </button>

    <dialog id="add-cavalier" class="dialog w-full sm:max-w-[500px] max-h-[80vh] overflow-y-auto" onclick="if (event.target === this) this.close()">
        <div>
            <header>
                <h2>Nouveau cavalier</h2>
                <p>Inscrivez un nouveau cavalier au centre.</p>
            </header>
            <section>
                <form action="" method="post" class="form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="flex flex-col gap-4">
                        
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col w-1/2">
                                <label>Nom</label>
                                <input class="input" type="text" name="nom" required>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label>Prénom</label>
                                <input class="input" type="text" name="prenom" required>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label>Type de monture préféré</label>
                            <select class="select w-full" name="codeTypeMonture" required>
                                <option value="" disabled selected>Sélectionner...</option>
                                <?php foreach ($typesMontures as $tm): ?>
                                    <option value="<?= htmlspecialchars($tm['codeTypeMonture']) ?>"><?= htmlspecialchars($tm['libTypeMonture']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex flex-col p-4 bg-muted rounded-lg mt-2">
                            <label class="font-bold mb-2">Type d'inscription</label>
                            <div class="flex gap-4 mb-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type_inscription" value="forfait" checked onchange="toggleInscriptionType()">
                                    Forfait Annuel
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type_inscription" value="tickets" onchange="toggleInscriptionType()">
                                    Tickets
                                </label>
                            </div>

                            <div id="section_forfait" class="flex flex-col gap-2">
                                <label class="text-sm font-semibold">Cochez les créneaux hebdomadaires :</label>
                                <div class="max-h-32 overflow-y-auto border border-border p-2 rounded bg-background">
                                    <?php foreach ($creneauxPlanning as $cp): ?>
                                        <label class="flex items-center gap-2 text-sm mb-1 cursor-pointer hover:bg-muted p-1 rounded">
                                            <input type="checkbox" name="creneaux[]" value="<?= $cp['numPlanning'] ?>">
                                            <?= htmlspecialchars($cp['jour'] . ' à ' . substr($cp['heure'],0,5) . ' - ' . $cp['libTypeReprise']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div id="section_tickets" class="flex flex-col hidden">
                                <label class="text-sm font-semibold">Nombre de tickets initial :</label>
                                <input class="input mt-1" type="number" name="nbTickets" min="1" placeholder="Ex: 10">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                            <button type="submit" name="btnAdd" class="btn" onclick="this.closest('dialog').close()">Inscrire</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </dialog>

    <div class="overflow-x-auto w-full">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom & Prénom</th>
                    <th>Monture</th>
                    <th>Type d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($cavaliers)): ?>
                    <tr><td colspan="4" class="text-center py-8 text-muted-foreground">Aucun cavalier inscrit.</td></tr>
                <?php else: ?>
                    <?php foreach ($cavaliers as $cav): ?>
                        <tr>
                            <td class="font-medium"><?= htmlspecialchars(strtoupper($cav['nomCavalier']) . ' ' . $cav['prenomCavalier']) ?></td>
                            <td><span class="badge-outline"><?= htmlspecialchars($cav['libTypeMonture']) ?></span></td>
                            <td>
                                <?php if (is_null($cav['nbTickets'])): ?>
                                    <span class="badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Forfait Annuel</span>
                                <?php else: ?>
                                    <span class="badge bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Tickets : <?= htmlspecialchars($cav['nbTickets']) ?> restants</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn-icon-outline cursor-pointer" onclick="document.getElementById('edit-dialog-<?= htmlspecialchars($cav['numCavalier']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6054)><path d="M13.2599 3.59924L5.04985 12.2892C4.73985 12.6192 4.43985 13.2692 4.37985 13.7192L4.00985 16.9592C3.87985 18.1292 4.71985 18.9292 5.87985 18.7292L9.09985 18.1792C9.54985 18.0992 10.1799 17.7692 10.4899 17.4292L18.6999 8.73924C20.1199 7.23924 20.7599 5.52924 18.5499 3.43924C16.3499 1.36924 14.6799 2.09924 13.2599 3.59924Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 /><path d="M11.8901 5.05078C12.3201 7.81078 14.5601 9.92078 17.3401 10.2008"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /><path d="M3 22H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /></g></svg>
                                </a>
                                <a class="btn-icon-destructive cursor-pointer" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($cav['numCavalier']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6145)><path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M10.3301 16.5H13.6601"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M9.5 12.5H14.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /></g></svg>
                                </a>
                            </td>
                        </tr>

                        <dialog id="edit-dialog-<?= htmlspecialchars($cav['numCavalier']) ?>" class="dialog w-full sm:max-w-[425px]" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2>Modifier le cavalier</h2>
                                </header>
                                <section>
                                    <form action="" method="post" class="form">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numCavalier" value="<?= htmlspecialchars($cav['numCavalier']) ?>">
                                        
                                        <div class="flex flex-col gap-2">
                                            <div class="flex gap-4">
                                                <div class="flex flex-col w-1/2">
                                                    <label>Nom</label>
                                                    <input class="input" type="text" name="nom" value="<?= htmlspecialchars($cav['nomCavalier']) ?>" required>
                                                </div>
                                                <div class="flex flex-col w-1/2">
                                                    <label>Prénom</label>
                                                    <input class="input" type="text" name="prenom" value="<?= htmlspecialchars($cav['prenomCavalier']) ?>" required>
                                                </div>
                                            </div>

                                            <div class="flex flex-col">
                                                <label>Type de monture</label>
                                                <select class="select w-full" name="codeTypeMonture" required>
                                                    <?php foreach ($typesMontures as $tm): ?>
                                                        <option value="<?= htmlspecialchars($tm['codeTypeMonture']) ?>" <?= $tm['codeTypeMonture'] == $cav['codeTypeMonture'] ? 'selected' : '' ?>><?= htmlspecialchars($tm['libTypeMonture']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="flex flex-col">
                                                <label>Tickets (Laissez vide pour Forfait)</label>
                                                <input class="input" type="number" name="nbTickets" value="<?= htmlspecialchars($cav['nbTickets']) ?>">
                                                <small class="text-muted-foreground mt-1">S'il est au forfait, ne remplissez pas ce champ.</small>
                                            </div>

                                            <div class="flex justify-end gap-2 mt-4">
                                                <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                                                <button type="submit" name="btnEdit" class="btn">Enregistrer</button>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </dialog>

                        <dialog id="alert-dialog-<?= htmlspecialchars($cav['numCavalier']) ?>" class="dialog" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2 class="text-red-500">⚠️ Supprimer ce cavalier ?</h2>
                                    <p>Voulez-vous vraiment supprimer <strong><?= htmlspecialchars($cav['nomCavalier']) ?></strong> ?</p>
                                </header>
                                <footer>
                                    <button class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numCavalier" value="<?= htmlspecialchars($cav['numCavalier']) ?>">
                                        <button type="submit" name="btnRemove" class="btn-destructive">Supprimer</button>
                                    </form>
                                </footer>
                            </div>
                        </dialog>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
function toggleInscriptionType() {
    const isForfait = document.querySelector('input[name="type_inscription"]:checked').value === 'forfait';
    const sectionForfait = document.getElementById('section_forfait');
    const sectionTickets = document.getElementById('section_tickets');
    const inputNbTickets = document.querySelector('input[name="nbTickets"]');

    if (isForfait) {
        sectionForfait.classList.remove('hidden');
        sectionTickets.classList.add('hidden');
        inputNbTickets.removeAttribute('required');
    } else {
        sectionForfait.classList.add('hidden');
        sectionTickets.classList.remove('hidden');
        inputNbTickets.setAttribute('required', 'required');
        
        document.querySelectorAll('input[name="creneaux[]"]').forEach(cb => cb.checked = false);
    }
}
</script>