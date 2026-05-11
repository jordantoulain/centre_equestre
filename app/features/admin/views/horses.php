<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    <h1 class="text-4xl font-bold text-center mb-10">Gestion des montures</h1>

    <button class="btn-ghost ml-auto mb-3" onclick="document.getElementById('add-horse').showModal()">
        <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6164)><g opacity=0.4><path d="M8 12H16"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M12 16V8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></svg>
        Nouvelle monture
    </button>
    <dialog id="add-horse" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
        <div>
            <header>
            <h2>Ajouter une monture</h2>
            <p>Ajoutez une nouvelle monture.</p>
            </header>

            <section>
            <form class="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col">
                        <label>Nom</label>
                        <input class="input" type="text" id="horse_name" name="horse_name" autofocus />
                    </div>
                    <div class="flex flex-col">
                        <label>Sexe</label>
                        <select class="select w-full" id="horse_sex" name="horse_sex">
                            <option value="Male">Male</option>
                            <option value="Femelle">Femelle</option>
                        </select>
                    </div>
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col w-full">
                            <label>Race</label>
                            <input class="input" type="text" id="horse_race" name="horse_race" />
                        </div>
                        <div class="flex flex-col w-full">
                            <label>Robe</label>
                            <input class="input" type="text" id="horse_robe" name="horse_robe" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label>Type</label>
                        <select class="select w-full" id="horse_type" name="horse_type">
                            <?php foreach($types as $type){ ?>
                                <option value="<?= $type["codeTypeMonture"] ?>"><?= htmlspecialchars($type["libTypeMonture"]) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col w-full">
                            <label>Poids</label>
                            <input class="input" type="number" id="horse_poids" name="horse_poids" />
                        </div>
                        <div class="flex flex-col w-full">
                            <label>Taille</label>
                            <input class="input" type="number" id="horse_taille" name="horse_taille" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label>Propriétaire</label>
                        <select class="select w-full" id="horse_owner" name="horse_owner">
                            <option value="">Centre</option>
                            <?php foreach($proprietaires as $proprietaire){ ?>
                                <option value="<?= $proprietaire["numCavalier"] ?>"><?= htmlspecialchars($proprietaire["nomCavalier"]) . " " . htmlspecialchars($proprietaire["prenomCavalier"]) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label>Image</label>
                        <input type="file" id="horse_image" name="horse_image" accept=".jpg,.jpeg,.png,.webp" />
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <input type="reset" value="Annuler" class="btn-outline" onclick="this.closest('dialog').close()"></input>
                        <input type="submit" name="btnAdd" value="Ajouter" class="btn" onclick="this.closest('dialog').close()"></input>
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
                <th><svg class="size-4" fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6093)><path d="M10 3L8 21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M16 3L14 21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M3.5 9H21.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.4 /><path d="M2.5 15H20.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.4 /></g></svg></th>
                <th>Nom</th>
                <th>Race</th>
                <th>Robe</th>
                <th>Type</th>
                <th>Sexe</th>
                <th>Poids</th>
                <th>Taille</th>
                <th>Propriétaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($horses as $horse){ ?>
                <tr>
                    <td><?= $horse["numMonture"] ?></td>
                    <td class="font-medium"><?= htmlspecialchars($horse["nomMonture"]) ?></td>
                    <td><?= htmlspecialchars($horse["race"]) ?></td>
                    <td><?= htmlspecialchars($horse["robe"]) ?></td>
                    <td><?= htmlspecialchars($horse["libTypeMonture"]) ?></td>
                    <td class="">
                        <span class="flex items-center gap-2"><?= $horse["sexe"] == "Femelle" ? '<svg fill=none class="size-5" height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6450)><path d="M12 16C15.866 16 19 12.866 19 9C19 5.13401 15.866 2 12 2C8.13401 2 5 5.13401 5 9C5 12.866 8.13401 16 12 16Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><g opacity=0.4><path d="M12 16V22"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M15 19H9"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></g><defs><clipPath id=clip0_4418_6450><rect fill=white height=24 width=24 /></clipPath></defs></svg>' : '<svg fill=none class="size-5" height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6449)><path d="M10.25 21.5C14.5302 21.5 18 18.0302 18 13.75C18 9.46979 14.5302 6 10.25 6C5.96979 6 2.5 9.46979 2.5 13.75C2.5 18.0302 5.96979 21.5 10.25 21.5Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><g opacity=0.4><path d="M21.5 2.5L16 8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M15 2.5H21.5V9"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></g><defs><clipPath id=clip0_4418_6449><rect fill=white height=24 width=24 /></clipPath></defs></svg>'; ?>
                        <?= $horse["sexe"] ?></span>
                    </td>
                    <td><?= htmlspecialchars($horse["poids"]) ?></td>
                    <td><?= htmlspecialchars($horse["taille"]) ?></td>
                    <td><?= empty($horse["numProprietaire"]) ? "Centre" : htmlspecialchars($horse["nomCavalier"]) . " " . htmlspecialchars($horse["prenomCavalier"])?></td>
                    <td>
                        <a class="btn-icon-outline" onclick="document.getElementById('edit-dialog-<?= $horse["numMonture"]?>').showModal()">
                            <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6054)><path d="M13.2599 3.59924L5.04985 12.2892C4.73985 12.6192 4.43985 13.2692 4.37985 13.7192L4.00985 16.9592C3.87985 18.1292 4.71985 18.9292 5.87985 18.7292L9.09985 18.1792C9.54985 18.0992 10.1799 17.7692 10.4899 17.4292L18.6999 8.73924C20.1199 7.23924 20.7599 5.52924 18.5499 3.43924C16.3499 1.36924 14.6799 2.09924 13.2599 3.59924Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 /><path d="M11.8901 5.05078C12.3201 7.81078 14.5601 9.92078 17.3401 10.2008"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /><path d="M3 22H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-miterlimit=10 stroke-width=1.5 opacity=0.4 /></g></svg>
                        </a>
                        <a class="btn-icon-destructive" onclick="document.getElementById('alert-dialog-<?= $horse["numMonture"]?>').showModal()">
                            <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6145)><path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M10.3301 16.5H13.6601"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /><path d="M9.5 12.5H14.5"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.34 /></g></svg>
                        </a>
                    </td>
                </tr>

                <dialog id="alert-dialog-<?= $horse["numMonture"]?>" class="dialog" onclick="if (event.target === this) this.close()">
                    <div>
                        <header>
                            <h2 class="flex items-center gap-2">
                                <svg class="text-red-500" fill=currentColor height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_4943)><path d="M21.76 15.92L15.36 4.4C14.5 2.85 13.31 2 12 2C10.69 2 9.49998 2.85 8.63998 4.4L2.23998 15.92C1.42998 17.39 1.33998 18.8 1.98998 19.91C2.63998 21.02 3.91998 21.63 5.59998 21.63H18.4C20.08 21.63 21.36 21.02 22.01 19.91C22.66 18.8 22.57 17.38 21.76 15.92Z"fill=currentColor style=fill:var(--fillg) opacity=0.4 /><path d="M12 14.75C11.59 14.75 11.25 14.41 11.25 14V9C11.25 8.59 11.59 8.25 12 8.25C12.41 8.25 12.75 8.59 12.75 9V14C12.75 14.41 12.41 14.75 12 14.75Z"fill=currentColor style=fill:var(--fillg) /><path d="M12 18.0005C11.94 18.0005 11.87 17.9905 11.8 17.9805C11.74 17.9705 11.68 17.9505 11.62 17.9205C11.56 17.9005 11.5 17.8705 11.44 17.8305C11.39 17.7905 11.34 17.7505 11.29 17.7105C11.11 17.5205 11 17.2605 11 17.0005C11 16.7405 11.11 16.4805 11.29 16.2905C11.34 16.2505 11.39 16.2105 11.44 16.1705C11.5 16.1305 11.56 16.1005 11.62 16.0805C11.68 16.0505 11.74 16.0305 11.8 16.0205C11.93 15.9905 12.07 15.9905 12.19 16.0205C12.26 16.0305 12.32 16.0505 12.38 16.0805C12.44 16.1005 12.5 16.1305 12.56 16.1705C12.61 16.2105 12.66 16.2505 12.71 16.2905C12.89 16.4805 13 16.7405 13 17.0005C13 17.2605 12.89 17.5205 12.71 17.7105C12.66 17.7505 12.61 17.7905 12.56 17.8305C12.5 17.8705 12.44 17.9005 12.38 17.9205C12.32 17.9505 12.26 17.9705 12.19 17.9805C12.13 17.9905 12.06 18.0005 12 18.0005Z"fill=currentColor style=fill:var(--fillg) /></g></svg>
                                Supprimer '<?= htmlspecialchars($horse["nomMonture"])?>' ?
                            </h2>
                            <p>Cette action ne peut pas être annulée. Cela supprimera définitivement la monture.</p>
                        </header>

                        <footer>
                        <button class="btn-outline" onclick="document.getElementById('alert-dialog-<?= $horse["numMonture"]?>').close()">Annuler</button>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="horse_id" value="<?= htmlspecialchars($horse["numMonture"]) ?>">
                            <input type="submit" name="btnRemove" class="btn-destructive" value="Continuer" onclick="document.getElementById('alert-dialog-<?= $horse["numMonture"]?>').close()">
                        </form>
                        </footer>
                    </div>
                </dialog>

                <dialog id="edit-dialog-<?= $horse["numMonture"]?>" class="dialog w-full sm:max-w-[425px] max-h-[612px]" onclick="if (event.target === this) this.close()">
                    <div>
                        <header>
                        <h2>Modifier la monture</h2>
                        <p>Effectuez les modifications souhaitées.</p>
                        </header>

                        <section>
                        <form class="form" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="horse_id" value="<?= htmlspecialchars($horse["numMonture"]) ?>">
                            <div class="flex flex-col gap-2">
                                <div class="flex flex-col">
                                    <label>Nom</label>
                                    <input class="input" type="text" value="<?= htmlspecialchars($horse["nomMonture"]) ?>" id="horse_name" name="horse_name" autofocus />
                                </div>
                                <div class="flex flex-col">
                                    <label>Sexe</label>
                                    <select class="select w-full" id="horse_sex" name="horse_sex">
                                        <option value="Male" <?= $horse["sexe"] == "Male" ? "selected" : "" ?>>Male</option>
                                        <option value="Femelle" <?= $horse["sexe"] == "Femelle" ? "selected" : "" ?>>Femelle</option>
                                    </select>
                                </div>
                                <div class="flex flex-row gap-4">
                                    <div class="flex flex-col w-full">
                                        <label>Race</label>
                                        <input class="input" type="text" value="<?= htmlspecialchars($horse["race"]) ?>" id="horse_race" name="horse_race" />
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <label>Robe</label>
                                        <input class="input" type="text" value="<?= htmlspecialchars($horse["robe"]) ?>" id="horse_robe" name="horse_robe" />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <label>Type</label>
                                    <select class="select w-full" id="horse_type" name="horse_type">
                                        <?php foreach($types as $type){ ?>
                                            <option value="<?= $type["codeTypeMonture"] ?>" <?= $horse["codeTypeMonture"] == $type["codeTypeMonture"] ? "selected" : "" ?>><?= htmlspecialchars($type["libTypeMonture"]) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="flex flex-row gap-4">
                                    <div class="flex flex-col w-full">
                                        <label>Poids</label>
                                        <input class="input" type="number" value="<?= htmlspecialchars($horse["poids"]) ?>" id="horse_poids" name="horse_poids" />
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <label>Taille</label>
                                        <input class="input" type="number" value="<?= htmlspecialchars($horse["taille"]) ?>" id="horse_taille" name="horse_taille" />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <label>Propriétaire</label>
                                    <select class="select w-full" id="horse_owner" name="horse_owner">
                                        <option value="" <?= $horse["numProprietaire"] == null ? "selected" : "" ?>>Centre</option>
                                        <?php foreach($proprietaires as $proprietaire){ ?>
                                            <option value="<?= $proprietaire["numCavalier"] ?>" <?= $horse["numProprietaire"] == $proprietaire["numCavalier"] ? "selected" : "" ?>><?= htmlspecialchars($proprietaire["nomCavalier"]) . " " . htmlspecialchars($proprietaire["prenomCavalier"]) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                    <input type="reset" value="Annuler" class="btn-outline" onclick="this.closest('dialog').close()"></input>
                                    <input type="submit" name="btnEdit" value="Sauvegarder" class="btn" onclick="this.closest('dialog').close()"></input>
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

            <?php } ?>
        </tbody>
        </table>
    </div>

    <?php
        if(isset($_POST['btnRemove']) && isset($_POST['horse_id'])){
            if($result) {
            ?>
                <div class="alert w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    <h2>Suppression réussie</h2>
                    <section>
                        La monture a été supprimée avec succès.
                    </section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur de suppression</h2>
                    <section>
                        Vérifiez que la monture existe encore ou n'est pas liée à une reprise.
                    </section>
                </div>
            <?php
            }
        }
    ?>

    <?php
        if(isset($_POST['btnEdit']) && isset($_POST['horse_id'])){
            if($result) {
            ?>
                <div class="alert w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    <h2>Modification réussie</h2>
                    <section>
                        La monture a été modifiée avec succès.
                    </section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur de modification</h2>
                    <section>
                        Vérifiez que la monture existe encore ou que le format des données est correcte.
                    </section>
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
                    <section>
                        La monture a été ajoutée avec succès.
                    </section>
                </div>
            <?php
            }else   {
            ?>
                <div class="alert-destructive w-2/3 max-w-100 mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg>
                    <h2>Erreur d'ajout</h2>
                    <section>
                        Une erreur est survenue lors de l'ajout de la monture.
                        <ul>
                            <?php foreach($errors as $error){ ?>
                                <li><?= $error ?></li>
                            <?php } ?>
                        </ul>
                    </section>
                </div>
            <?php
            }
        }
    ?>
</section>