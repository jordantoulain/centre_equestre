<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    <h1 class="text-4xl font-bold text-center mb-2">Gestion des Types de Reprises</h1>
    <p class="text-muted-foreground text-center mb-10">Définissez les types de cours, le moniteur référent et le type de monture requis.</p>

    <button class="btn-ghost ml-auto mb-3" onclick="document.getElementById('add-type-reprise').showModal()">
        <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6164)><g opacity=0.4><path d="M8 12H16"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M12 16V8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></svg>
        Nouveau type
    </button>

    <dialog id="add-type-reprise" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
        <div>
            <header>
                <h2>Nouveau type de reprise</h2>
                <p>Créez un nouveau type de cours.</p>
            </header>
            <section>
                <form action="" method="post" class="form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-col">
                            <label>Nom du type (ex: Dressage Débutant)</label>
                            <input class="input" type="text" name="nom_type" placeholder="Entrez le nom..." required>
                        </div>

                        <div class="flex flex-col">
                            <label>Moniteur responsable</label>
                            <select class="select w-full" name="id_moniteur" required>
                                <option value="" disabled selected>Choisir un moniteur...</option>
                                <?php foreach ($moniteurs as $m): ?>
                                    <option value="<?= htmlspecialchars($m['numMoniteur']) ?>">
                                        <?= htmlspecialchars($m['prenomMoniteur'] . ' ' . $m['nomMoniteur']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label>Type de monture requis</label>
                            <select class="select w-full" name="type_monture" required>
                                <option value="" disabled selected>Choisir le type...</option>
                                <?php foreach ($typesMontures as $tm): ?>
                                    <option value="<?= htmlspecialchars($tm['codeTypeMonture']) ?>">
                                        <?= htmlspecialchars($tm['libTypeMonture']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                            <button type="submit" name="btnAdd" class="btn" onclick="this.closest('dialog').close()">Créer le type</button>
                        </div>
                    </div>
                </form>
            </section>
            <button type="button" onclick="this.closest('dialog').close()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </dialog>

    <div class="overflow-x-auto w-full">
        <table class="table">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Moniteur Responsable</th>
                    <th>Type de Monture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($typesReprises)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-8 text-muted-foreground">Aucun type de reprise défini pour le moment.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($typesReprises as $type): ?>
                        <tr>
                            <td class="font-medium"><?= htmlspecialchars($type['libTypeReprise']) ?></td>
                            <td><?= htmlspecialchars($type['prenomMoniteur'] . ' ' . $type['nomMoniteur']) ?></td>
                            <td>
                                <span class="badge-outline"><?= htmlspecialchars($type['libTypeMonture']) ?></span>
                            </td>
                            <td>
                                <a class="btn-icon-outline cursor-pointer" onclick="document.getElementById('edit-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6054)><path d="M13.2599 3.59924L5.04985 12.2892C4.73985 12.6192 4.43985 13.2692 4.37985 13.7192L4.00985 16.9592C3.87985 18.1292 4.71985 18.9292 5.87985 18.7292L9.09985 18.1792C9.54985 18.0992 10.1799 17.7692 10.4899 17.4292L18.6999 8.73924C20.1199 7.23924 20.7599 5.52924 18.5499 3.43924C16.3499 1.36924 14.6799 2.09924 13.2599 3.59924Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 /><path d="M11.8901 5.05078C12.3201 7.81078 14.5601 9.92078 17.3401 10.2008"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /><path d="M3 22H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /></g></svg>
                                </a>
                                <a class="btn-icon-destructive cursor-pointer" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>').showModal()">
                                    <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6145)><path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M10.3301 16.5H13.6601"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M9.5 12.5H14.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /></g></svg>
                                </a>
                            </td>
                        </tr>

                        <dialog id="edit-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2>Modifier le type</h2>
                                    <p>Effectuez les modifications souhaitées.</p>
                                </header>
                                <section>
                                    <form action="" method="post" class="form">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="id_type_reprise" value="<?= htmlspecialchars($type['codeTypeReprise']) ?>">
                                        
                                        <div class="flex flex-col gap-2">
                                            <div class="flex flex-col">
                                                <label>Nom du type</label>
                                                <input class="input" type="text" name="nom_type" value="<?= htmlspecialchars($type['libTypeReprise']) ?>" required>
                                            </div>

                                            <div class="flex flex-col">
                                                <label>Moniteur responsable</label>
                                                <select class="select w-full" name="id_moniteur" required>
                                                    <?php foreach ($moniteurs as $m): ?>
                                                        <option value="<?= htmlspecialchars($m['numMoniteur']) ?>" <?= $m['numMoniteur'] == $type['numMoniteur'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($m['prenomMoniteur'] . ' ' . $m['nomMoniteur']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="flex flex-col">
                                                <label>Type de monture</label>
                                                <select class="select w-full" name="type_monture" required>
                                                    <?php foreach ($typesMontures as $tm): ?>
                                                        <option value="<?= htmlspecialchars($tm['codeTypeMonture']) ?>" <?= $tm['codeTypeMonture'] == $type['codeTypeMonture'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($tm['libTypeMonture']) ?>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </button>
                            </div>
                        </dialog>

                        <dialog id="alert-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>" class="dialog" onclick="if (event.target === this) this.close()">
                            <div>
                                <header>
                                    <h2 class="flex items-center gap-2">
                                        <svg class="text-red-500" fill=currentColor height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_4943)><path d="M21.76 15.92L15.36 4.4C14.5 2.85 13.31 2 12 2C10.69 2 9.49998 2.85 8.63998 4.4L2.23998 15.92C1.42998 17.39 1.33998 18.8 1.98998 19.91C2.63998 21.02 3.91998 21.63 5.59998 21.63H18.4C20.08 21.63 21.36 21.02 22.01 19.91C22.66 18.8 22.57 17.38 21.76 15.92Z"fill=currentColor style=fill:var(--fillg) opacity=0.4 /><path d="M12 14.75C11.59 14.75 11.25 14.41 11.25 14V9C11.25 8.59 11.59 8.25 12 8.25C12.41 8.25 12.75 8.59 12.75 9V14C12.75 14.41 12.41 14.75 12 14.75Z"fill=currentColor style=fill:var(--fillg) /><path d="M12 18.0005C11.94 18.0005 11.87 17.9905 11.8 17.9805C11.74 17.9705 11.68 17.9505 11.62 17.9205C11.56 17.9005 11.5 17.8705 11.44 17.8305C11.39 17.7905 11.34 17.7505 11.29 17.7105C11.11 17.5205 11 17.2605 11 17.0005C11 16.7405 11.11 16.4805 11.29 16.2905C11.34 16.2505 11.39 16.2105 11.44 16.1705C11.5 16.1305 11.56 16.1005 11.62 16.0805C11.68 16.0505 11.74 16.0305 11.8 16.0205C11.93 15.9905 12.07 15.9905 12.19 16.0205C12.26 16.0305 12.32 16.0505 12.38 16.0805C12.44 16.1005 12.5 16.1305 12.56 16.1705C12.61 16.2105 12.66 16.2505 12.71 16.2905C12.89 16.4805 13 16.7405 13 17.0005C13 17.2605 12.89 17.5205 12.71 17.7105C12.66 17.7505 12.61 17.7905 12.56 17.8305C12.5 17.8705 12.44 17.9005 12.38 17.9205C12.32 17.9505 12.26 17.9705 12.19 17.9805C12.13 17.9905 12.06 18.0005 12 18.0005Z"fill=currentColor style=fill:var(--fillg) /></g></svg>
                                        Supprimer '<?= htmlspecialchars($type['libTypeReprise']) ?>' ?
                                    </h2>
                                    <p>Voulez-vous vraiment supprimer ce type ? Cette action est irréversible.</p>
                                </header>
                                <footer>
                                    <button class="btn-outline" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>').close()">Annuler</button>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="id_type_reprise" value="<?= htmlspecialchars($type['codeTypeReprise']) ?>">
                                        <button type="submit" name="btnRemove" class="btn-destructive" onclick="document.getElementById('alert-dialog-<?= htmlspecialchars($type['codeTypeReprise']) ?>').close()">Continuer</button>
                                    </form>
                                </footer>
                            </div>
                        </dialog>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
        if(isset($_POST['btnRemove']) && isset($_POST['id_type_reprise'])){
            if($result) {
            ?>
                <div class="alert w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    <h2>Suppression réussie</h2>
                    <section>Le type de reprise a été supprimé avec succès.</section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur de suppression</h2>
                    <section>Vérifiez que ce type n'est pas utilisé dans le planning ou une reprise existante.</section>
                </div>
            <?php
            }
        }
    ?>

    <?php
        if(isset($_POST['btnEdit']) && isset($_POST['id_type_reprise'])){
            if($result) {
            ?>
                <div class="alert w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    <h2>Modification réussie</h2>
                    <section>Le type de reprise a été modifié avec succès.</section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur de modification</h2>
                    <section>Vérifiez que le format des données est correct.</section>
                </div>
            <?php
            }
        }
    ?>

    <?php
        if(isset($_POST['btnAdd'])){
            if($result) {
            ?>
                <div class="alert w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    <h2>Ajout réussi</h2>
                    <section>Le type de reprise a été ajouté avec succès.</section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur d'ajout</h2>
                    <section>Une erreur est survenue lors de l'ajout du type de reprise.</section>
                </div>
            <?php
            }
        }
    ?>
</section>