<section class="container mx-auto flex flex-col my-auto items-center justify-center">
    
    <div class="w-full bg-muted p-6 rounded-lg mb-8 flex justify-between items-center border border-border mt-4">
        <div>
            <a href="/?p=adminReprises" class="text-sm text-blue-500 hover:underline mb-2 inline-block">← Retour aux reprises</a>
            <h1 class="text-3xl font-bold mb-1">Séance du <?= htmlspecialchars(date('d/m/Y', strtotime($reprise['dateReprise']))) ?></h1>
            <p class="text-muted-foreground text-lg">
                <?= htmlspecialchars($reprise['jour']) ?> à <?= htmlspecialchars(substr($reprise['heure'], 0, 5)) ?> • 
                <strong><?= htmlspecialchars($reprise['libTypeReprise']) ?></strong> • 
                Moniteur : <?= htmlspecialchars($reprise['prenomMoniteur'] . ' ' . $reprise['nomMoniteur']) ?>
            </p>
        </div>
        <div>
            <button class="btn" onclick="document.getElementById('add-cavalier-dialog').showModal()">
                + Ajouter un cavalier (Rattrapage / Ticket)
            </button>
        </div>
    </div>

    <?php if(!empty($error_message)): ?>
        <div class="alert-destructive w-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <h2>Action refusée</h2><section><?= htmlspecialchars($error_message) ?></section>
        </div>
    <?php endif; ?>
    <?php if(!empty($success_message)): ?>
        <div class="alert w-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            <h2>Succès</h2><section><?= htmlspecialchars($success_message) ?></section>
        </div>
    <?php endif; ?>

    <div class="w-full">
        <h2 class="text-2xl font-bold mb-4">Cavaliers inscrits (<?= count($inscrits) ?>)</h2>
        <div class="overflow-x-auto card p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cavalier</th>
                        <th>Statut Forfait/Ticket</th>
                        <th>Monture assignée</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inscrits)): ?>
                        <tr><td colspan="4" class="text-center py-8 text-muted-foreground">Aucun cavalier n'est inscrit à cette séance.</td></tr>
                    <?php else: ?>
                        <?php foreach ($inscrits as $inscrit): ?>
                            <tr>
                                <td class="font-medium"><?= htmlspecialchars(strtoupper($inscrit['nomCavalier']) . ' ' . $inscrit['prenomCavalier']) ?></td>
                                <td>
                                    <?php if ($inscrit['rattrapage'] == 1): ?>
                                        <span class="badge bg-purple-100 text-purple-800">Rattrapage</span>
                                    <?php elseif ($inscrit['nbTickets'] !== null && $inscrit['nbTickets'] !== ''): ?>
                                        <span class="badge bg-blue-100 text-blue-800">Tickets (<?= htmlspecialchars($inscrit['nbTickets']) ?> restants)</span>
                                    <?php else: ?>
                                        <span class="badge bg-green-100 text-green-800">Forfait Annuel</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" class="flex gap-2 m-0 items-center">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numCavalier" value="<?= $inscrit['numCavalier'] ?>">
                                        
                                        <select name="numMonture" class="select select-sm w-48">
                                            <option value="">-- Non assigné --</option>
                                            <?php foreach ($montures as $m): ?>
                                                <option value="<?= $m['numMonture'] ?>" <?= ($inscrit['numMonture'] == $m['numMonture']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($m['nomMonture']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" name="btnAssignMonture" class="btn-outline small">OK</button>
                                    </form>
                                </td>
                                <td class="text-right">
                                    <form method="POST" class="inline m-0" onsubmit="return confirm('Marquer ce cavalier comme absent et le retirer de la liste ?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="numCavalier" value="<?= $inscrit['numCavalier'] ?>">
                                        <button type="submit" name="btnRemove" class="btn-destructive small">Retirer / Absent</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <dialog id="add-cavalier-dialog" class="dialog w-full sm:max-w-[450px]" onclick="if (event.target === this) this.close()">
        <div>
            <header>
                <h2>Ajouter à la séance</h2>
                <p>Inscrire un cavalier pour un rattrapage ou avec un ticket.</p>
            </header>
            <section>
                <form action="" method="post" class="form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    
                    <input type="hidden" name="hiddenMethodeAjout" id="hiddenMethodeAjout" value="">
                    
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col">
                            <label>Sélectionner le cavalier</label>
                            <select class="select w-full" name="numCavalier" id="selectCavalierAdd" required onchange="checkCavalierStatus()">
                                <option value="" disabled selected>Choisir...</option>
                                <?php foreach ($cavaliersDispos as $cd): ?>
                                    <option value="<?= $cd['numCavalier'] ?>">
                                        <?= htmlspecialchars(strtoupper($cd['nomCavalier']) . ' ' . $cd['prenomCavalier']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="cavalierStatusBox" class="hidden p-3 rounded bg-muted border border-border">
                            <p class="text-sm font-bold mb-2" id="statusText"></p>
                            
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 opacity-50" id="labelRattrapage">
                                    <input type="radio" id="radioRattrapage" onclick="event.preventDefault()">
                                    Rattrapage (Forfait)
                                </label>
                                <label class="flex items-center gap-2 opacity-50" id="labelTicket">
                                    <input type="radio" id="radioTicket" onclick="event.preventDefault()">
                                    Consommer 1 Ticket
                                </label>
                            </div>
                            <p class="text-xs text-red-500 mt-2 font-bold hidden" id="noTicketWarning">Attention, ce cavalier a 0 ticket.</p>
                        </div>

                        <div class="flex flex-col">
                            <label>Monture (Optionnel)</label>
                            <select class="select w-full" name="numMonture">
                                <option value="">-- A définir plus tard --</option>
                                <?php foreach ($montures as $m): ?>
                                    <option value="<?= $m['numMonture'] ?>"><?= htmlspecialchars($m['nomMonture']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" class="btn-outline" onclick="this.closest('dialog').close()">Annuler</button>
                            <button type="submit" name="btnAddCavalier" id="btnSubmitAdd" class="btn" disabled>Ajouter</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </dialog>

    <script>
        const cavaliersData = <?= json_encode($cavaliersJS) ?>;

        function checkCavalierStatus() {
            const select = document.getElementById('selectCavalierAdd');
            const numCavalier = select.value;
            const statusBox = document.getElementById('cavalierStatusBox');
            const statusText = document.getElementById('statusText');
            
            const radioRattrapage = document.getElementById('radioRattrapage');
            const labelRattrapage = document.getElementById('labelRattrapage');
            
            const radioTicket = document.getElementById('radioTicket');
            const labelTicket = document.getElementById('labelTicket');
            
            const noTicketWarning = document.getElementById('noTicketWarning');
            const btnSubmitAdd = document.getElementById('btnSubmitAdd');
            const hiddenMethodeAjout = document.getElementById('hiddenMethodeAjout'); 

            if (!numCavalier) return;
            
            const data = cavaliersData[numCavalier];
            statusBox.classList.remove('hidden');
            noTicketWarning.classList.add('hidden');

            if (data.nbTickets === null) {
                statusText.innerHTML = "Cavalier avec Forfait Annuel";
                
                radioRattrapage.checked = true;
                labelRattrapage.classList.remove('opacity-50');
                
                radioTicket.checked = false;
                labelTicket.classList.add('opacity-50');
                
                hiddenMethodeAjout.value = 'rattrapage';
                btnSubmitAdd.disabled = false;
            } else {
                statusText.innerHTML = `Cavalier sans forfait (Tickets restants : ${data.nbTickets})`;
                
                radioRattrapage.checked = false;
                labelRattrapage.classList.add('opacity-50');
                
                radioTicket.checked = true;
                labelTicket.classList.remove('opacity-50');

                hiddenMethodeAjout.value = 'ticket';

                if (data.nbTickets > 0) {
                    btnSubmitAdd.disabled = false;
                } else {
                    btnSubmitAdd.disabled = true;
                    noTicketWarning.classList.remove('hidden');
                }
            }
        }
    </script>
</section>