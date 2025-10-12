{{-- Modal pour afficher l'image CNI --}}
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%; background: white; border-radius: 15px; padding: 20px;">
        <button onclick="closeImageModal()" style="position: absolute; top: 10px; right: 15px; background: #f56565; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; font-weight: bold;">×</button>
        <h3 id="modalTitle" style="margin: 0 0 15px 0; color: #2d3748; text-align: center;"></h3>
        <img id="modalImage" style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px;">
        <div style="text-align: center; margin-top: 15px;">
            <button onclick="downloadImage()" style="background: #4299e1; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                📥 Télécharger
            </button>
        </div>
    </div>
</div>

{{-- Modal pour raison de désactivation --}}
<div id="raisonModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1001; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <h3 style="margin: 0 0 20px 0; color: #2d3748; text-align: center; font-size: 1.3rem;">
            ⚠️ Motif de désactivation
        </h3>

        <form id="raisonForm" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Raison de la suspension :
                </label>
                <select id="raisonSelect" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" onchange="toggleCustomRaison()">
                    <option value="">Sélectionner une raison...</option>
                    <option value="Documents incomplets">Documents incomplets</option>
                    <option value="Informations incorrectes">Informations incorrectes</option>
                    <option value="Vérification en cours">Vérification en cours</option>
                    <option value="Non-conformité">Non-conformité aux conditions</option>
                    <option value="Demande utilisateur">Demande de l'utilisateur</option>
                    <option value="Autre">Autre (préciser)</option>
                </select>
            </div>

            <div id="customRaisonDiv" style="display: none;">
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Préciser la raison :
                </label>
                <textarea id="customRaison" placeholder="Veuillez préciser la raison de la suspension..."
                    style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
            </div>

            <div id="messageDiv">
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Message supplémentaire (optionnel) :
                </label>
                <textarea id="messageSupplementaire" placeholder="Message qui sera ajouté à l'email..."
                    style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                <button type="button" onclick="closeRaisonModal()"
                    style="background: #a0aec0; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    ❌ Annuler
                </button>
                <button type="button" onclick="confirmerDesactivation()"
                    style="background: #f56565; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    ⚠️ Confirmer la suspension
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal pour raison de désactivation --}}



@if(auth()->user()->role !== 'gestionnaire_compte')
<div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin: 20px; color: #dc2626; text-align: center;">
    <h3>Accès non autorisé</h3>
    <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
</div>
@else
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1400px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Dashboard Gestionnaire</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Gestion des comptes utilisateurs</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <button onclick="exportData()" style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        📊 Exporter
                    </button>
                    <button onclick="refreshData()" style="background: #4299e1; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        🔄 Actualiser
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalComptes ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Comptes</p>
                    </div>
                    <div style="font-size: 2rem;">👥</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $comptesActifs ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Comptes Actifs</p>
                    </div>
                    <div style="font-size: 2rem;">✅</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #ed8936, #dd6b20); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $comptesInactifs ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Attente</p>
                    </div>
                    <div style="font-size: 2rem;">⏳</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #9f7aea, #805ad5); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $comptesAujourdhui ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Créés Aujourd'hui</p>
                    </div>
                    <div style="font-size: 2rem;">📅</div>
                </div>
            </div>
        </div>

        {{-- Filtres et Recherche --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Rechercher</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom, CNI..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; transition: all 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Statut</label>
                    <select name="status" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous</option>
                        <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Ville</label>
                    <select name="ville" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Toutes</option>
                        @foreach($villes ?? [] as $ville)
                        <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1;">
                        🔍 Filtrer
                    </button>
                    <a href="{{ route('dashboard') }}" style="background: #a0aec0; color: white; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                        ❌ Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tableau des comptes --}}
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="background: linear-gradient(135deg, #2d3748, #4a5568); color: white; padding: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">Gestion des Comptes</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f7fafc;">
                        <tr>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Photo CNI</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Identité</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Contact</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Localisation</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Type Compte</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Solde</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Date Déblocage</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Statut</th>
                            <th style="padding: 15px; text-align: center; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comptes ?? [] as $compte)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f7fafc'" onmouseout="this.style.backgroundColor='white'">
                            <!-- Photo CNI -->
                            <td style="padding: 15px;">
                                @php
                                // Récupère la valeur JSON ou unique selon le format
                                $photos = is_array($compte->photo_cni)
                                ? $compte->photo_cni
                                : (json_decode($compte->photo_cni, true) ?: [$compte->photo_cni]);
                                @endphp

                                @if (!empty($photos) && $photos[0] !== null)
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    @foreach ($photos as $photo)
                                    @if ($photo && file_exists(storage_path('app/public/' . $photo)))
                                    <img src="{{ asset('storage/' . $photo) }}"
                                        onclick="showImageModal('{{ asset('storage/' . $photo) }}', '{{ $compte->nom }} {{ $compte->prenom }}')"
                                        style="width: 60px; height: 40px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid #e2e8f0; transition: all 0.3s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'"
                                        alt="CNI de {{ $compte->nom }} {{ $compte->prenom }}">
                                    @endif
                                    @endforeach
                                </div>
                                @else
                                <div style="width: 60px; height: 40px; background: #f7fafc; border: 2px dashed #cbd5e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #a0aec0; font-size: 0.8rem;">
                                    📄 Aucune image
                                </div>
                                @endif
                            </td>


                            <!-- Identité -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $compte->nom }} {{ $compte->prenom }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">CNI: {{ $compte->cni }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ \Carbon\Carbon::parse($compte->date_naissance)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($compte->date_naissance)->age }} ans)</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $compte->sexe }}</div>
                            </td>

                            <!-- Contact -->
                            <td style="padding: 15px;">
                                <div style="margin-bottom: 5px;">📞 {{ $compte->telephone }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">🚨 {{ $compte->contact_urgence }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">📱 {{ $compte->tel_urgence }}</div>
                            </td>

                            <!-- Localisation -->
                            <td style="padding: 15px;">
                                <div style="margin-bottom: 3px;">🌍 {{ $compte->pays }}</div>
                                <div style="margin-bottom: 3px;">🏙️ {{ $compte->ville }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">📍 {{ $compte->quartier }}</div>
                                @if($compte->lieudit)
                                <div style="font-size: 0.9rem; color: #718096;">{{ $compte->lieudit }}</div>
                                @endif
                            </td>

                            <!-- Type Compte -->
                            <td style="padding: 15px; font-weight: 600; color: #2d3748;">{{ ucfirst($compte->type_compte) }}</td>

                            <!-- Solde -->
                            <td style="padding: 15px;">
                                @if($compte->status == 'actif')
                                <form action="{{ route('comptes.updateSolde', $compte->id) }}" method="POST" style="display:flex; gap:5px; align-items:center;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="solde" value="{{ $compte->solde }}" style="width: 100px; padding:3px; border-radius:5px; border:1px solid #ccc;">
                                    <button type="submit" style="background: #ecc94b; color: white; border: none; padding: 5px 8px; border-radius: 5px; cursor: pointer;">💰</button>
                                </form>
                                @else
                                {{ number_format($compte->solde, 0, ',', ' ') }} FCFA
                                @endif
                            </td>


                            <!-- Date Déblocage -->
                            <td style="padding: 15px;">
                                @if($compte->type_compte == 'bloque' || $compte->type_compte == 'terme')
                                {{ \Carbon\Carbon::parse($compte->date_deblocage)->format('d/m/Y') }}
                                @else
                                -
                                @endif
                            </td>

                            <!-- Statut -->
                            <td style="padding: 15px;">
                                <span style="padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; 
                                    {{ $compte->status == 'actif' ? 'background: #c6f6d5; color: #22543d;' : 'background: #fed7d7; color: #742a2a;' }}">
                                    {{ $compte->status == 'actif' ? '✅ Actif' : '⏳ Inactif' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($compte->status == 'inactif')
                                    <button onclick="activerCompte({{ $compte->id }})"
                                        style="background: #48bb78; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        ✅ Activer
                                    </button>
                                    @else
                                    <button onclick="desactiverCompte({{ $compte->id }})"
                                        style="background: #f56565; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        ❌ Désactiver
                                    </button>
                                    @endif

                                    <button onclick="voirDetails({{ $compte->id }})"
                                        style="background: #4299e1; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        👁️ Détails
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="padding: 40px; text-align: center; color: #718096;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">📭</div>
                                <h3 style="margin: 0; color: #2d3748;">Aucun compte trouvé</h3>
                                <p style="margin: 10px 0 0 0;">Aucun compte ne correspond aux critères de recherche.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($comptes) && $comptes->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f7fafc;">
                {{ $comptes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal pour afficher l'image CNI --}}
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%; background: white; border-radius: 15px; padding: 20px;">
        <button onclick="closeImageModal()" style="position: absolute; top: 10px; right: 15px; background: #f56565; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; font-weight: bold;">×</button>
        <h3 id="modalTitle" style="margin: 0 0 15px 0; color: #2d3748; text-align: center;"></h3>
        <img id="modalImage" style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px;">
        <div style="text-align: center; margin-top: 15px;">
            <button onclick="downloadImage()" style="background: #4299e1; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                📥 Télécharger
            </button>
        </div>
    </div>
</div>

<script>
    let currentImageUrl = '';
    let compteToDesactivate = null;

    function showImageModal(imageUrl, title) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalTitle').textContent = 'CNI - ' + title;
        document.getElementById('imageModal').style.display = 'flex';
        currentImageUrl = imageUrl;
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    function closeRaisonModal() {
        document.getElementById('raisonModal').style.display = 'none';
        document.getElementById('raisonSelect').value = '';
        document.getElementById('customRaison').value = '';
        document.getElementById('messageSupplementaire').value = '';
        document.getElementById('customRaisonDiv').style.display = 'none';
        compteToDesactivate = null;
    }

    function toggleCustomRaison() {
        const select = document.getElementById('raisonSelect');
        const customDiv = document.getElementById('customRaisonDiv');

        if (select.value === 'Autre') {
            customDiv.style.display = 'block';
        } else {
            customDiv.style.display = 'none';
        }
    }

    function downloadImage() {
        const link = document.createElement('a');
        link.href = currentImageUrl;
        link.download = 'CNI_' + document.getElementById('modalTitle').textContent.replace('CNI - ', '') + '.jpg';
        link.click();
    }

    function activerCompte(id) {
        if (confirm('Êtes-vous sûr de vouloir activer ce compte ?')) {
            // Afficher un indicateur de chargement
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '⏳ Activation...';
            button.disabled = true;

            fetch(`/gestionnaire/comptes/${id}/activer`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('✅ ' + data.message);
                        location.reload();
                    } else {
                        alert('❌ ' + (data.message || 'Erreur lors de l\'activation du compte'));
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('❌ Erreur de connexion. Vérifiez votre connexion internet.');
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }
    }

    function desactiverCompte(id) {
        compteToDesactivate = id;
        document.getElementById('raisonModal').style.display = 'flex';
    }

    function confirmerDesactivation() {
        const raisonSelect = document.getElementById('raisonSelect');
        const customRaison = document.getElementById('customRaison');
        const messageSupplementaire = document.getElementById('messageSupplementaire');

        let raison = '';

        if (raisonSelect.value === '') {
            alert('❌ Veuillez sélectionner une raison de suspension');
            return;
        }

        if (raisonSelect.value === 'Autre') {
            if (customRaison.value.trim() === '') {
                alert('❌ Veuillez préciser la raison de suspension');
                return;
            }
            raison = customRaison.value.trim();
        } else {
            raison = raisonSelect.value;
        }

        // Ajouter le message supplémentaire si fourni
        if (messageSupplementaire.value.trim() !== '') {
            raison += '\n\nMessage supplémentaire: ' + messageSupplementaire.value.trim();
        }

        // Désactiver le bouton et afficher le chargement
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '⏳ Suspension...';
        button.disabled = true;

        fetch(`/gestionnaire/comptes/${compteToDesactivate}/desactiver`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    raison: raison
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    closeRaisonModal();
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Erreur lors de la désactivation du compte'));
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('❌ Erreur de connexion. Vérifiez votre connexion internet.');
                button.innerHTML = originalText;
                button.disabled = false;
            });
    }



    function exportData() {
        window.location.href = '/gestionnaire/comptes/export';
    }

    function refreshData() {
        location.reload();
    }

    // Fermer les modals en cliquant à l'extérieur
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    document.getElementById('raisonModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRaisonModal();
        }
    });

    // Fermer les modals avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
            closeRaisonModal();
        }
    });

    // Test de diagnostic (à supprimer après résolution)
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]') ? 'Présent' : 'Manquant');
    console.log('User role:', '{{ auth()->user()->role ?? "Non connecté" }}');

    // Test de connectivité
    function testRoute(id) {
        console.log('Test route activation pour ID:', id);
        console.log('URL construite:', `/gestionnaire/comptes/${id}/activer`);
    }
</script>

@endif