{{-- resources/views/dashboard.blade.php --}}
@if(auth()->user()->role !== 'gestionnaire_compte')
<div class="unauthorized-box">
    <h3>Accès non autorisé</h3>
    <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
</div>
@else
<div class="page-bg">
    <div class="container">

        {{-- Header --}}
        <div class="card header-card">
            <div class="header-inner">
                <div>
                    <h1 class="title">Dashboard Gestionnaire</h1>
                    <p class="subtitle">Gestion des comptes utilisateurs</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-success" onclick="exportData()">📊 Exporter</button>
                    <button class="btn btn-info" onclick="refreshData()">🔄 Actualiser</button>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="grid stats-grid">
            <div class="stat-card stat-1">
                <div class="stat-inner">
                    <div>
                        <h3 class="stat-number">{{ $totalComptes ?? 0 }}</h3>
                        <p class="stat-label">Total Comptes</p>
                    </div>
                    <div class="stat-icon">👥</div>
                </div>
            </div>

            <div class="stat-card stat-2">
                <div class="stat-inner">
                    <div>
                        <h3 class="stat-number">{{ $comptesActifs ?? 0 }}</h3>
                        <p class="stat-label">Comptes Actifs</p>
                    </div>
                    <div class="stat-icon">✅</div>
                </div>
            </div>

            <div class="stat-card stat-3">
                <div class="stat-inner">
                    <div>
                        <h3 class="stat-number">{{ $comptesInactifs ?? 0 }}</h3>
                        <p class="stat-label">En Attente</p>
                    </div>
                    <div class="stat-icon">⏳</div>
                </div>
            </div>

            <div class="stat-card stat-4">
                <div class="stat-inner">
                    <div>
                        <h3 class="stat-number">{{ $comptesAujourdhui ?? 0 }}</h3>
                        <p class="stat-label">Créés Aujourd'hui</p>
                    </div>
                    <div class="stat-icon">📅</div>
                </div>
            </div>
        </div>

        {{-- Filtres et Recherche --}}
        <div class="card filters-card">
            <form method="GET" class="filters-form">
                <div class="form-col">
                    <label class="field-label">Rechercher</label>
                    <input class="field-input" type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom, CNI...">
                </div>

                <div class="form-col">
                    <label class="field-label">Statut</label>
                    <select class="field-input" name="status">
                        <option value="">Tous</option>
                        <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>

                <div class="form-col">
                    <label class="field-label">Ville</label>
                    <select class="field-input" name="ville">
                        <option value="">Toutes</option>
                        @foreach($villes ?? [] as $ville)
                        <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-col actions-col">
                    <button type="submit" class="btn btn-info full">🔍 Filtrer</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-neutral full">❌ Reset</a>
                </div>
            </form>
        </div>

        {{-- Tableau des comptes --}}
        <div class="card table-card">
            <div class="table-header">
                <h2>Gestion des Comptes</h2>
            </div>

            <div class="table-wrapper">
                <table class="accounts-table">
                    <thead>
                        <tr>
                            <th>Photo CNI</th>
                            <th>Identité</th>
                            <th>Contact</th>
                            <th>Localisation</th>
                            <th>Type Compte</th>
                            <th>Solde</th>
                            <th>Date Déblocage</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($comptes ?? [] as $compte)
                        <tr>
                            {{-- Photo CNI --}}
                            <td data-label="Photo CNI" class="cni-cell">
                                @php
                                    $photos = is_array($compte->photo_cni)
                                        ? $compte->photo_cni
                                        : (json_decode($compte->photo_cni, true) ?: [$compte->photo_cni]);
                                @endphp

                                @if (!empty($photos) && $photos[0] !== null)
                                <div class="cni-list">
                                    @foreach ($photos as $photo)
                                        @if ($photo)
                                            <img src="{{ asset('storage/' . $photo) }}"
                                                alt="CNI de {{ $compte->nom }} {{ $compte->prenom }}"
                                                class="cni-thumb"
                                                onclick="showImageModal('{{ asset('storage/' . $photo) }}', '{{ $compte->nom }} {{ $compte->prenom }}')">
                                        @endif
                                    @endforeach
                                </div>
                                @else
                                <div class="no-image">📄 Aucune image</div>
                                @endif
                            </td>

                            {{-- Identité --}}
                            <td data-label="Identité">
                                <div class="name">{{ $compte->nom }} {{ $compte->prenom }}</div>
                                <div class="muted">CNI: {{ $compte->cni }}</div>
                                <div class="muted">{{ \Carbon\Carbon::parse($compte->date_naissance)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($compte->date_naissance)->age }} ans)</div>
                                <div class="muted">{{ $compte->sexe }}</div>
                            </td>

                            {{-- Contact --}}
                            <td data-label="Contact">
                                <div>📞 {{ $compte->telephone }}</div>
                                <div class="muted">🚨 {{ $compte->contact_urgence }}</div>
                                <div class="muted">📱 {{ $compte->tel_urgence }}</div>
                            </td>

                            {{-- Localisation --}}
                            <td data-label="Localisation">
                                <div>🌍 {{ $compte->pays }}</div>
                                <div>🏙️ {{ $compte->ville }}</div>
                                <div class="muted">📍 {{ $compte->quartier }}</div>
                                @if($compte->lieudit)
                                <div class="muted">{{ $compte->lieudit }}</div>
                                @endif
                            </td>

                            {{-- Type Compte --}}
                            <td data-label="Type Compte" class="bold">{{ ucfirst($compte->type_compte) }}</td>

                            {{-- Solde --}}
                            <td data-label="Solde">
                                @if($compte->status == 'actif')
                                <form action="{{ route('comptes.updateSolde', $compte->id) }}" method="POST" class="solde-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="solde" value="{{ $compte->solde }}" class="solde-input">
                                    <button type="submit" class="btn btn-yellow">💰</button>
                                </form>
                                @else
                                {{ number_format($compte->solde, 0, ',', ' ') }} FCFA
                                @endif
                            </td>

                            {{-- Date Déblocage --}}
                            <td data-label="Date Déblocage">
                                @if($compte->type_compte == 'bloque' || $compte->type_compte == 'terme')
                                    {{ \Carbon\Carbon::parse($compte->date_deblocage)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Statut --}}
                            <td data-label="Statut">
                                <span class="status-pill {!! $compte->status == 'actif' ? 'status-active' : 'status-inactive' !!}">
                                    {{ $compte->status == 'actif' ? '✅ Actif' : '⏳ Inactif' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td data-label="Actions" class="actions-cell">
                                <div class="actions">
                                    @if($compte->status == 'inactif')
                                    <button onclick="activerCompte({{ $compte->id }}, event)" class="btn btn-success small">✅ Activer</button>
                                    @else
                                    <button onclick="desactiverCompte({{ $compte->id }})" class="btn btn-danger small">❌ Désactiver</button>
                                    @endif

                                    <button onclick="voirDetails({{ $compte->id }})" class="btn btn-info small">👁️ Détails</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-row">
                                <div class="empty-emoji">📭</div>
                                <h3>Aucun compte trouvé</h3>
                                <p>Aucun compte ne correspond aux critères de recherche.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($comptes) && $comptes->hasPages())
            <div class="pagination-bar">
                {{ $comptes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal pour afficher l'image CNI --}}
<div id="imageModal" class="modal-backdrop" aria-hidden="true" style="display: none;">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <button class="modal-close" onclick="closeImageModal()" aria-label="Fermer">×</button>
        <h3 id="modalTitle" class="modal-title"></h3>
        <img id="modalImage" class="modal-image" alt="">
        <div class="modal-actions">
            <button class="btn btn-info" onclick="downloadImage()">📥 Télécharger</button>
        </div>
    </div>
</div>

{{-- Modal pour raison de désactivation --}}
<div id="raisonModal" class="modal-backdrop" aria-hidden="true" style="display: none;">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="raisonTitle">
        <button class="modal-close" onclick="closeRaisonModal()" aria-label="Fermer">×</button>
        <h3 id="raisonTitle" class="modal-title">⚠️ Motif de désactivation</h3>

        <form id="raisonForm" class="raison-form" onsubmit="event.preventDefault(); confirmerDesactivation(event);">
            <div class="form-group">
                <label>Raison de la suspension :</label>
                <select id="raisonSelect" class="field-input" onchange="toggleCustomRaison()">
                    <option value="">Sélectionner une raison...</option>
                    <option value="Documents incomplets">Documents incomplets</option>
                    <option value="Informations incorrectes">Informations incorrectes</option>
                    <option value="Vérification en cours">Vérification en cours</option>
                    <option value="Non-conformité">Non-conformité aux conditions</option>
                    <option value="Demande utilisateur">Demande de l'utilisateur</option>
                    <option value="Autre">Autre (préciser)</option>
                </select>
            </div>

            <div id="customRaisonDiv" style="display:none;">
                <label>Préciser la raison :</label>
                <textarea id="customRaison" class="field-textarea" placeholder="Veuillez préciser la raison..."></textarea>
            </div>

            <div class="form-group">
                <label>Message supplémentaire (optionnel) :</label>
                <textarea id="messageSupplementaire" class="field-textarea" placeholder="Message qui sera ajouté à l'email..."></textarea>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn btn-neutral" onclick="closeRaisonModal()">❌ Annuler</button>
                <button type="submit" class="btn btn-danger">⚠️ Confirmer la suspension</button>
            </div>
        </form>
    </div>
</div>

{{-- Styles centralisés (tu peux extraire vers un fichier CSS si tu veux) --}}
<style>
/* Base layout */
:root { --bg-grad: linear-gradient(135deg,#667eea 0%,#764ba2 100%); --muted: #718096; --card-bg: #fff; }
*{box-sizing:border-box;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;}
.page-bg{min-height:100vh;background:var(--bg-grad);padding:20px;}
.container{max-width:1400px;margin:0 auto;}
.card{background:var(--card-bg);border-radius:15px;padding:20px;margin-bottom:20px;box-shadow:0 5px 20px rgba(0,0,0,0.08);}

/* unauthorized */
.unauthorized-box{background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:16px;margin:20px;color:#dc2626;text-align:center;}

/* header */
.header-card{padding:28px;}
.header-inner{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;}
.title{color:#2d3748;margin:0;font-size:2rem;font-weight:700;}
.subtitle{color:var(--muted);margin:5px 0 0 0;font-size:1.05rem;}
.header-actions{display:flex;gap:12px;flex-wrap:wrap;}

/* stats grid */
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.stat-card{padding:18px;border-radius:12px;color:#fff;}
.stat-inner{display:flex;justify-content:space-between;align-items:center;}
.stat-number{margin:0;font-size:1.9rem;font-weight:700;}
.stat-label{margin:6px 0 0 0;opacity:0.95;}
.stat-1{background:linear-gradient(135deg,#667eea,#764ba2);}
.stat-2{background:linear-gradient(135deg,#48bb78,#38a169);}
.stat-3{background:linear-gradient(135deg,#ed8936,#dd6b20);}
.stat-4{background:linear-gradient(135deg,#9f7aea,#805ad5);}

/* filters */
.filters-card{padding:18px;}
.filters-form{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;align-items:end;}
.field-label{display:block;font-weight:600;color:#2d3748;margin-bottom:6px;}
.field-input{width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:8px;font-size:14px;}
.actions-col{display:flex;gap:10px;}

/* table */
.table-card{padding:0;overflow:hidden;}
.table-header{background:linear-gradient(135deg,#2d3748,#4a5568);color:#fff;padding:16px;}
.table-header h2{margin:0;font-size:1.2rem;}
.table-wrapper{overflow-x:auto;padding:18px;}
.accounts-table{width:100%;border-collapse:collapse;min-width:900px;}
.accounts-table thead th{padding:15px;text-align:left;font-weight:600;color:#2d3748;border-bottom:2px solid #e2e8f0;background:#f7fafc;}
.accounts-table tbody tr{border-bottom:1px solid #e2e8f0;transition:all .2s;}
.accounts-table tbody tr:hover{background:#f7fafc;}
.accounts-table td{padding:15px;vertical-align:top;}

/* photo block */
.cni-list{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.cni-thumb{width:50px;height:34px;object-fit:cover;border-radius:8px;cursor:pointer;border:2px solid #e2e8f0;transition:transform .15s;}
.cni-thumb:hover{transform:scale(1.05);}
.no-image{width:60px;height:40px;background:#f7fafc;border:2px dashed #cbd5e0;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#a0aec0;font-size:0.8rem;}

/* small utilities */
.muted{color:var(--muted);font-size:0.9rem;margin-top:4px;}
.bold{font-weight:600;}
.actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;}
.btn{border:none;padding:10px 14px;border-radius:8px;cursor:pointer;font-weight:600;}
.btn.small{padding:8px 10px;font-size:0.9rem;}
.btn-success{background:#48bb78;color:#fff;}
.btn-danger{background:#f56565;color:#fff;}
.btn-info{background:#4299e1;color:#fff;}
.btn-yellow{background:#ecc94b;color:#fff;}
.btn-neutral{background:#a0aec0;color:#fff;}
.full{flex:1;display:inline-block;text-align:center;}

/* solde form */
.solde-form{display:flex;gap:6px;align-items:center;}
.solde-input{width:100px;padding:6px;border-radius:6px;border:1px solid #ccc;}

/* status pill */
.status-pill{display:inline-block;padding:8px 12px;border-radius:999px;font-size:0.85rem;font-weight:600;}
.status-active{background:#c6f6d5;color:#22543d;}
.status-inactive{background:#fed7d7;color:#742a2a;}

/* empty state */
.empty-row{padding:40px;text-align:center;color:var(--muted);}
.empty-emoji{font-size:3rem;margin-bottom:12px;}

/* pagination */
.pagination-bar{padding:20px;border-top:1px solid #e2e8f0;background:#f7fafc;}

/* modal common */
.modal-backdrop{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:1000;display:flex;justify-content:center;align-items:center;padding:20px;}
.modal-content{background:#fff;border-radius:14px;max-width:720px;width:100%;max-height:90vh;overflow:auto;padding:20px;position:relative;}
.modal-close{position:absolute;top:12px;right:12px;background:#f56565;color:#fff;border:none;width:36px;height:36px;border-radius:50%;font-size:1.2rem;cursor:pointer;}
.modal-title{text-align:center;margin:0 0 12px 0;color:#2d3748;}
.modal-image{display:block;max-width:100%;max-height:70vh;margin:0 auto;border-radius:10px;object-fit:contain;}
.modal-actions{text-align:center;margin-top:12px;}

/* raison form */
.raison-form .form-group{margin-bottom:12px;}
.field-textarea{width:100%;min-height:80px;padding:12px;border:2px solid #e2e8f0;border-radius:8px;font-size:14px;}

/* responsive adjustments */
@media (max-width: 1024px){
    .header-inner{flex-direction:column;align-items:flex-start;}
    .table-wrapper{padding:12px;}
}

/* mobile: transform table into cards, reduce thumb size a touch */
@media (max-width: 768px){
    .accounts-table{min-width:unset;font-size:0.95rem;}
    .accounts-table thead{display:none;}
    .accounts-table tbody, .accounts-table tr, .accounts-table td{display:block;width:100%;}
    .accounts-table tr{background:#fff;margin-bottom:12px;border-radius:12px;padding:12px;box-shadow:0 3px 10px rgba(0,0,0,0.04);border:none;}
    .accounts-table td{padding:8px 6px;border:none;}
    .accounts-table td::before{content:attr(data-label);display:block;font-weight:600;color:#555;margin-bottom:6px;}
    .cni-thumb{width:80px;height:55px;border-radius:6px;}
    .actions{flex-direction:column;}
    .btn.full{width:100%;}
    .modal-content{padding:15px;}
    .modal-image{max-height:55vh;}
}
</style>

{{-- Script (JS amélioré, event fixes) --}}
<script>
    let currentImageUrl = '';
    let compteToDesactivate = null;

    function showImageModal(imageUrl, title) {
        const modal = document.getElementById('imageModal');
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalImage').alt = 'CNI - ' + title;
        document.getElementById('modalTitle').textContent = 'CNI - ' + title;
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
        currentImageUrl = imageUrl;
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        document.getElementById('modalImage').src = '';
    }

    function openRaisonModalFor(id) {
        compteToDesactivate = id;
        const modal = document.getElementById('raisonModal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    }

    // kept for backward compat with existing onclick that calls desactiverCompte(id)
    function desactiverCompte(id){
        compteToDesactivate = id;
        document.getElementById('raisonModal').style.display = 'flex';
    }

    function closeRaisonModal() {
        const modal = document.getElementById('raisonModal');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        document.getElementById('raisonSelect').value = '';
        document.getElementById('customRaison').value = '';
        document.getElementById('messageSupplementaire').value = '';
        document.getElementById('customRaisonDiv').style.display = 'none';
        compteToDesactivate = null;
    }

    function toggleCustomRaison() {
        const select = document.getElementById('raisonSelect');
        const customDiv = document.getElementById('customRaisonDiv');
        if (!select) return;
        customDiv.style.display = select.value === 'Autre' ? 'block' : 'none';
    }

    function downloadImage() {
        if (!currentImageUrl) return;
        const link = document.createElement('a');
        link.href = currentImageUrl;
        const name = document.getElementById('modalTitle').textContent.replace('CNI - ', '').replace(/\s+/g, '_');
        link.download = 'CNI_' + name + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // activerCompte expects event to change the button text & disable it while fetching
    function activerCompte(id, e) {
        if (!confirm('Êtes-vous sûr de vouloir activer ce compte ?')) return;
        const button = e ? e.target : null;
        const originalText = button ? button.innerHTML : 'Activation...';
        if (button) { button.innerHTML = '⏳ Activation...'; button.disabled = true; }

        fetch(`/gestionnaire/comptes/${id}/activer`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        }).then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + (data.message || 'Erreur lors de l\'activation du compte'));
                if (button) { button.innerHTML = originalText; button.disabled = false; }
            }
        }).catch(err => {
            console.error(err);
            alert('❌ Erreur de connexion. Vérifiez votre connexion internet.');
            if (button) { button.innerHTML = originalText; button.disabled = false; }
        });
    }

    function confirmerDesactivation(e) {
        e = e || window.event;
        const raisonSelect = document.getElementById('raisonSelect');
        const customRaison = document.getElementById('customRaison');
        const messageSupplementaire = document.getElementById('messageSupplementaire');

        if (!raisonSelect || !compteToDesactivate) {
            alert('❌ Données manquantes.');
            return;
        }

        if (raisonSelect.value === '') {
            alert('❌ Veuillez sélectionner une raison de suspension');
            return;
        }

        let raison = raisonSelect.value === 'Autre' ? (customRaison.value || '').trim() : raisonSelect.value;
        if (raisonSelect.value === 'Autre' && raison === '') {
            alert('❌ Veuillez préciser la raison de suspension');
            return;
        }

        if (messageSupplementaire && messageSupplementaire.value.trim() !== '') {
            raison += '\n\nMessage supplémentaire: ' + messageSupplementaire.value.trim();
        }

        // disable submit button
        const submitBtn = e && e.target ? e.target : document.querySelector('#raisonForm button[type="submit"]');
        const originalText = submitBtn ? submitBtn.innerHTML : '⏳ Suspension...';
        if (submitBtn) { submitBtn.innerHTML = '⏳ Suspension...'; submitBtn.disabled = true; }

        fetch(`/gestionnaire/comptes/${compteToDesactivate}/desactiver`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ raison })
        }).then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        }).then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                closeRaisonModal();
                location.reload();
            } else {
                alert('❌ ' + (data.message || 'Erreur lors de la désactivation du compte'));
                if (submitBtn) { submitBtn.innerHTML = originalText; submitBtn.disabled = false; }
            }
        }).catch(err => {
            console.error(err);
            alert('❌ Erreur de connexion. Vérifiez votre connexion internet.');
            if (submitBtn) { submitBtn.innerHTML = originalText; submitBtn.disabled = false; }
        });
    }

    function exportData(){ window.location.href = '/gestionnaire/comptes/export'; }
    function refreshData(){ location.reload(); }

    // close modals on backdrop click or Escape
    document.addEventListener('click', function(e){
        ['imageModal','raisonModal'].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            if (e.target === el) {
                if (id === 'imageModal') closeImageModal();
                if (id === 'raisonModal') closeRaisonModal();
            }
        });
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') { closeImageModal(); closeRaisonModal(); }
    });

    // debug logs (optional)
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]') ? 'Présent' : 'Manquant');
    console.log('User role:', '{{ auth()->user()->role ?? "Non connecté" }}');

    // placeholder for voirDetails (le backend / route devrait exister)
    function voirDetails(id){
        // tu peux remplacer par une navigation ou une ouverture de modal
        window.location.href = `/gestionnaire/comptes/${id}`;
    }
</script>

@endif
