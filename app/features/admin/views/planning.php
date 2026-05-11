<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    <h1 class="text-4xl font-bold text-center mb-2">Planning Hebdomadaire</h1>
    <p class="text-muted-foreground text-center mb-10">Définissez la semaine type du centre équestre. Les moniteurs pourront ensuite créer des séances à des dates précises basées sur ces créneaux.</p>

    <button class="btn-ghost ml-auto mb-3" onclick="document.getElementById('add-creneau').showModal()">
        <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6164)><g opacity=0.4><path d="M8 12H16"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M12 16V8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></svg>
        Nouveau créneau
    </button>

    <dialog id="add-creneau" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
        <div>
            <header>
                <h2>Ajouter un créneau</h2>
                <p>Ajoutez un nouveau cours récurrent au planning.</p>
            </header>
            <section>
                <form action="" method="post" class="form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="flex flex-col gap-4">
                        
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col w-1/2">
                                <label>Jour</label>
                                <select class="select w-full" name="jour" required>
                                    <option value="" disabled selected>Choisir...</option>
                                    <?php foreach ($joursSemaine as $j): ?>
                                        <option value="<?= $j ?>"><?= $j ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label>Heure</label>
                                <input class="input" type="time" name="heure" required>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label>Type de reprise (et Moniteur)</label>
                            <select class="select w-full" name="codeTypeReprise" required>
                                <option value="" disabled selected>Sélectionner le cours...</option>
                                <?php foreach ($typesReprises as $tr): ?>
                                    <option value="<?= htmlspecialchars($tr['codeTypeReprise']) ?>">
                                        <?= htmlspecialchars($tr['libTypeReprise']) ?> (<?= htmlspecialchars($tr['prenomMoniteur'] . ' ' . $tr['nomMoniteur']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                            <button type="submit" name="btnAdd" class="btn" onclick="this.closest('dialog').close()">Créer le créneau</button>
                        </div>
                    </div>
                </form>
            </section>
            <button type="button" onclick="this.closest('dialog').close()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18" /><path d="m6 6 12 12" /></svg>
            </button>
        </div>
    </dialog>

    <div class="overflow-x-auto w-full">
        <table class="table">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure</th>
                    <th>Type de Reprise</th>
                    <th>Moniteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($creneaux)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-8 text-muted-foreground">Le planning est actuellement vide.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($creneaux as $creneau): ?>
                        <tr>
                            <td class="font-medium"><?= htmlspecialchars($creneau['jour']) ?></td>
                            <td><?= htmlspecialchars(substr($creneau['heure'], 0, 5)) // Format HH:MM ?></td>
                            <td>
                                <span class="badge-outline"><?= htmlspecialchars($creneau['libTypeReprise']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($creneau['prenomMoniteur'] . ' ' . $creneau['nomMoniteur']) ?></td>
                            <td>
                                <a class="btn-icon-outline cursor-pointer" onclick="document.getElementById('edit-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6054)><path d="M13.2599 3.59924L5.04985 12.2892C4.73985 12.6192 4.43985 13.2692 4.37985 13.7192L4.00985 16.9592C3.87985 18.1292 4.71985 18.9292 5.87985 18.7292L9.09985 18.1792C9.54985 18.0992 10.1799 17.7692 10.4899 17.4292L18.6999 8.73924C20.1199 7.23924 20.7599 5.52924 18.5499 3.43924C16.3499 1.36924 14.6799 2.09924 13.2599 3.59924Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 /><path d="M11.8901 5.05078C12.3201 7.81078 14.5601 9.92078 17.3401 10.2008"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /><path d="M3 22H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /></g></svg>
                                </a>
                                <a class="btn-icon-destructive cursor-pointer" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6145)><path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M10.3301 16.5H13.6601"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M9.5 12.5H14.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /></g></svg>
                                </a>
                            </td>
                        </tr>

                        <dialog id="edit-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2>Modifier le créneau</h2>
                                    <p>Effectuez les modifications souhaitées.</p>
                                </header>
                                <section>
                                    <form action="" method="post" class="form">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numPlanning" value="<?= htmlspecialchars($creneau['numPlanning']) ?>">
                                        
                                        <div class="flex flex-col gap-4">
                                            <div class="flex gap-4 w-full">
                                                <div class="flex flex-col w-1/2">
                                                    <label>Jour</label>
                                                    <select class="select w-full" name="jour" required>
                                                        <?php foreach ($joursSemaine as $j): ?>
                                                            <option value="<?= $j ?>" <?= $j === $creneau['jour'] ? 'selected' : '' ?>><?= $j ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="flex flex-col w-1/2">
                                                    <label>Heure</label>
                                                    <input class="input" type="time" name="heure" value="<?= htmlspecialchars($creneau['heure']) ?>" required>
                                                </div>
                                            </div>

                                            <div class="flex flex-col">
                                                <label>Type de reprise (et Moniteur)</label>
                                                <select class="select w-full" name="codeTypeReprise" required>
                                                    <?php foreach ($typesReprises as $tr): ?>
                                                        <option value="<?= htmlspecialchars($tr['codeTypeReprise']) ?>" <?= $tr['codeTypeReprise'] == $creneau['codeTypeReprise'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($tr['libTypeReprise']) ?> (<?= htmlspecialchars($tr['prenomMoniteur'] . ' ' . $tr['nomMoniteur']) ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="flex justify-end gap-2 mt-4">
                                                <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                                                <button type="submit" name="btnEdit" class="btn" onclick="this.closest('dialog').close()">Enregistrer</button>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                                <button type="button" onclick="this.closest('dialog').close()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18" /><path d="m6 6 12 12" /></svg>
                                </button>
                            </div>
                        </dialog>

                        <dialog id="alert-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>" class="dialog" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2 class="flex items-center gap-2 text-red-500">
                                        ⚠️ Supprimer ce créneau ?
                                    </h2>
                                    <p>Voulez-vous vraiment supprimer le créneau du <strong><?= htmlspecialchars($creneau['jour']) ?> à <?= htmlspecialchars(substr($creneau['heure'], 0, 5)) ?></strong> ?</p>
                                </header>
                                <footer>
                                    <button class="btn-outline" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>').close()">Annuler</button>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numPlanning" value="<?= htmlspecialchars($creneau['numPlanning']) ?>">
                                        <button type="submit" name="btnRemove" class="btn-destructive" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($creneau['numPlanning']) ?>').close()">Continuer</button>
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