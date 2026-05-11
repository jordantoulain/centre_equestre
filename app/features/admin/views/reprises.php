<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    <h1 class="text-4xl font-bold text-center mb-2">Gestion des Reprises</h1>
    <p class="text-muted-foreground text-center mb-10">Créez des séances à des dates précises à partir du planning. Les cavaliers au forfait seront inscrits automatiquement.</p>

    <?php if(!empty($error_message)): ?>
        <div class="alert-destructive w-2/3 max-w-100 mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
            <h2>Erreur de création</h2>
            <section><?= htmlspecialchars($error_message) ?></section>
        </div>
    <?php endif; ?>

    <button class="btn-ghost ml-auto mb-3" onclick="document.getElementById('add-reprise').showModal()">
        <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><path d="M8 12H16"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M12 16V8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></svg>
        Nouvelle Reprise
    </button>

    <dialog id="add-reprise" class="dialog w-full sm:max-w-[425px]" onclick="if (event.target === this) this.close()">
        <div>
            <header>
                <h2>Créer une reprise</h2>
                <p>Sélectionnez un créneau et validez la date.</p>
            </header>
            <section>
                <form action="" method="post" class="form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    
                    <input type="hidden" name="jourPrevu" id="jourPrevu" value="">

                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col">
                            <label>Créneau du planning</label>
                            <select class="select w-full" name="numPlanning" id="selectPlanning" required onchange="updateJourPrevu()">
                                <option value="" disabled selected>Choisir un créneau...</option>
                                <?php foreach ($plannings as $p): ?>
                                    <option value="<?= htmlspecialchars($p['numPlanning']) ?>" data-jour="<?= htmlspecialchars($p['jour']) ?>">
                                        <?= htmlspecialchars($p['jour'] . ' à ' . substr($p['heure'],0,5) . ' - ' . $p['libTypeReprise'] . ' (' . $p['nomMoniteur'] . ')') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label>Date de la séance</label>
                            <input class="input" type="date" name="dateReprise" required>
                            <small class="text-muted-foreground mt-1" id="jourWarning">Attention, la date doit correspondre au jour du créneau sélectionné.</small>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                            <button type="submit" name="btnAdd" class="btn">Générer la séance</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </dialog>

    <script>
        function updateJourPrevu() {
            const select = document.getElementById('selectPlanning');
            const selectedOption = select.options[select.selectedIndex];
            const jour = selectedOption.getAttribute('data-jour');
            document.getElementById('jourPrevu').value = jour;
            document.getElementById('jourWarning').innerText = "La date choisie devra obligatoirement être un " + jour + ".";
            document.getElementById('jourWarning').classList.add('text-blue-500', 'font-semibold');
        }
    </script>

    <div class="overflow-x-auto w-full">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Type de Reprise</th>
                    <th>Moniteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reprises)): ?>
                    <tr><td colspan="5" class="text-center py-8 text-muted-foreground">Aucune reprise n'a été créée.</td></tr>
                <?php else: ?>
                    <?php foreach ($reprises as $rep): ?>
                        <tr>
                            <td class="font-bold"><?= htmlspecialchars(date('d/m/Y', strtotime($rep['dateReprise']))) ?></td>
                            <td><?= htmlspecialchars($rep['jour'] . ' à ' . substr($rep['heure'],0,5)) ?></td>
                            <td><span class="badge-outline"><?= htmlspecialchars($rep['libTypeReprise']) ?></span></td>
                            <td><?= htmlspecialchars($rep['prenomMoniteur'] . ' ' . $rep['nomMoniteur']) ?></td>
                            <td>
                                <a href="./?p=adminReprisesDetail&id=<?= htmlspecialchars($rep['numReprise']) ?>" class="btn-outline small mr-2">
                                    Faire l'appel / Assigner
                                </a>
                                
                                <a class="btn-icon-destructive cursor-pointer" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($rep['numReprise']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6145)><path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M10.3301 16.5H13.6601"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M9.5 12.5H14.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /></g></svg>
                                </a>
                            </td>
                        </tr>

                        <dialog id="alert-dialog-<?= htmlspecialchars($rep['numReprise']) ?>" class="dialog" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2 class="text-red-500">Supprimer cette séance ?</h2>
                                    <p>Voulez-vous vraiment annuler la séance du <strong><?= htmlspecialchars(date('d/m/Y', strtotime($rep['dateReprise']))) ?></strong> ?</p>
                                </header>
                                <footer>
                                    <button class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numReprise" value="<?= htmlspecialchars($rep['numReprise']) ?>">
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