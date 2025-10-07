@extends('layouts.home')
@section('content')
{{-- Dashboard Administrateur - Vue globale du système --}}
<section style="min-height: 100vh; background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); padding: 20px;">

    @if(auth()->user()->role !== 'admin')
    <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin: 20px; color: #dc2626; text-align: center;">
        <h3>Accès non autorisé</h3>
        <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
    </div>
    @else
    <div style="max-width: 1600px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #1a202c; margin: 0; font-size: 2.2rem; font-weight: 700;">🎯 Dashboard Administrateur</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Vue d'ensemble et gestion du système</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <button onclick="exportGlobalReport()" style="background: #10b981; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        📊 Exporter Rapport Global
                    </button>
                    <button onclick="location.reload()" style="background: #3b82f6; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        🔄 Actualiser
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques Globales --}}
        <div style="margin-bottom: 30px;">
            <h2 style="color: white; margin: 0 0 20px 0; font-size: 1.5rem; font-weight: 600;">📈 Vue d'ensemble du système</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">

                {{-- Utilisateurs --}}
                <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalUtilisateurs ?? 0 }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Utilisateurs</p>
                        </div>
                        <div style="font-size: 2rem;">👥</div>
                    </div>
                </div>

                {{-- Comptes --}}
                <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalComptes ?? 0 }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Comptes</p>
                        </div>
                        <div style="font-size: 2rem;">💳</div>
                    </div>
                </div>

                {{-- Crédits --}}
                <div style="background: linear-gradient(135deg, #ec4899, #db2777); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalCredits ?? 0 }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Crédits</p>
                        </div>
                        <div style="font-size: 2rem;">💰</div>
                    </div>
                </div>

                {{-- Import/Export --}}
                <div style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalImportExport ?? 0 }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Import/Export</p>
                        </div>
                        <div style="font-size: 2rem;">🚢</div>
                    </div>
                </div>

                {{-- Projets --}}
                <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalProjets ?? 0 }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Projets</p>
                        </div>
                        <div style="font-size: 2rem;">🎯</div>
                    </div>
                </div>

                {{-- Montant Total Crédits --}}
                <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.3rem; font-weight: 700;">{{ number_format($montantTotalCredits ?? 0, 0, ',', ' ') }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Crédits (FCFA)</p>
                        </div>
                        <div style="font-size: 2rem;">💵</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sections principales --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 30px; margin-bottom: 30px;">

            {{-- Gestion des utilisateurs et rôles --}}
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 20px;">
                    <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">👥 Gestion des Utilisateurs</h2>
                </div>
                <div style="padding: 25px;">
                    <button onclick="toggleModal('addAdminModal')" style="width: 100%; background: #10b981; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem; margin-bottom: 20px;">
                        ➕ Ajouter un Administrateur
                    </button>
                    <button onclick="toggleModal('assignRoleModal')" style="width: 100%; background: #3b82f6; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                        🎭 Attribuer un Rôle
                    </button>

                    <div style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e5e7eb;">
                        <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 1.1rem;">📊 Statistiques par rôle</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Admin</span>
                                <span style="color: #6366f1; font-weight: 700;">{{ $statsRoles['admin'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Gestionnaire Compte</span>
                                <span style="color: #8b5cf6; font-weight: 700;">{{ $statsRoles['gestionnaire_compte'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Gestionnaire Crédit</span>
                                <span style="color: #ec4899; font-weight: 700;">{{ $statsRoles['gestionnaire_credit'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Gest. Import/Export</span>
                                <span style="color: #06b6d4; font-weight: 700;">{{ $statsRoles['gest-import'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Gest. Financement</span>
                                <span style="color: #f59e0b; font-weight: 700;">{{ $statsRoles['gest-financement'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                                <span style="font-weight: 600;">Clients</span>
                                <span style="color: #10b981; font-weight: 700;">{{ $statsRoles['user'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activité récente --}}
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px;">
                    <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">Activité Récente</h2>
                </div>
                <div style="padding: 25px; max-height: 400px; overflow-y: auto;">
                    @forelse($activitesRecentes ?? [] as $activite)
                    <div style="padding: 12px; border-left: 4px solid {{ 
            $activite->type === 'user' ? '#6366f1' : 
            ($activite->type === 'compte' ? '#8b5cf6' : 
            ($activite->type === 'credit' ? '#ec4899' : 
            ($activite->type === 'import' ? '#06b6d4' : '#f59e0b'))) 
        }}; background: #f9fafb; margin-bottom: 12px; border-radius: 6px;">
                        <div style="display: flex; align-items: start; gap: 10px;">
                            <span style="font-size: 1.2rem;">{{ $activite->icon }}</span>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">{{ $activite->description }}</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">{{ $activite->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px; color: #9ca3af;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                        <p>Aucune activité récente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tableau de tous les utilisateurs --}}
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #1f2937, #374151); color: white; padding: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">👤 Tous les Utilisateurs</h2>
            </div>

            {{-- Filtres --}}
            <div style="padding: 20px; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Rechercher</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email..."
                            style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Rôle</label>
                        <select name="role" style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                            <option value="">Tous les rôles</option>
                            <option value="admin">Admin</option>
                            <option value="gestionnaire_compte">Gestionnaire Compte</option>
                            <option value="gestionnaire_credit">Gestionnaire Crédit</option>
                            <option value="gest-import">Gest. Import/Export</option>
                            <option value="gest-financement">Gest. Financement</option>
                            <option value="client">Client</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1;">
                            🔍 Filtrer
                        </button>
                        <a href="{{ route('dashboard') }}" style="background: #9ca3af; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            🔄 Reset
                        </a>
                    </div>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f9fafb;">
                        <tr>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Utilisateur</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Email</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Rôle</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Statut</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Inscription</th>
                            <th style="padding: 15px; text-align: center; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs ?? [] as $user)
                        <tr style="border-bottom: 1px solid #e5e7eb; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='white'">
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #1f2937;">{{ $user->name }}</div>
                            </td>
                            <td style="padding: 15px;">
                                <div style="color: #6b7280;">{{ $user->email }}</div>
                            </td>
                            <td style="padding: 15px;">
                                @php
                                $roleColors = [
                                'admin' => 'background: #dbeafe; color: #1e40af;',
                                'gestionnaire_compte' => 'background: #ede9fe; color: #6b21a8;',
                                'gestionnaire_credit' => 'background: #fce7f3; color: #9f1239;',
                                'gest-import' => 'background: #cffafe; color: #155e75;',
                                'gest-financement' => 'background: #fef3c7; color: #92400e;',
                                'client' => 'background: #d1fae5; color: #065f46;'
                                ];
                                @endphp
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; {{ $roleColors[$user->role] ?? 'background: #f3f4f6; color: #4b5563;' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: #d1fae5; color: #065f46;">
                                    ✓ Actif
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                <div style="font-size: 0.9rem; color: #6b7280;">{{ $user->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button onclick="editUser({{ $user->id }})" style="background: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                        ✏️ Modifier
                                    </button>
                                    @if($user->role !== 'admin' || auth()->id() !== $user->id)
                                    <button onclick="deleteUser({{ $user->id }})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                        🗑️ Supprimer
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #9ca3af;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">👥</div>
                                <h3 style="margin: 0; color: #374151;">Aucun utilisateur trouvé</h3>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($utilisateurs) && $utilisateurs->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e5e7eb; background: #f9fafb;">
                {{ $utilisateurs->links() }}
            </div>
            @endif
        </div>

    </div>
    @endif

    {{-- Modal Ajouter Admin --}}
    <div id="addAdminModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 20px 0; color: #1f2937; font-size: 1.5rem;">➕ Ajouter un Administrateur</h3>
            <form action="{{ route('users.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">

                @csrf
                <input type="hidden" name="role" value="admin">
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Nom complet</label>
                    <input type="text" name="name" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Email</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Mot de passe</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Confirmer mot de passe</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <button type="button" onclick="toggleModal('addAdminModal')" style="flex: 1; background: #9ca3af; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Annuler
                    </button>
                    <button type="submit" style="flex: 1; background: #10b981; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Créer Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Attribuer Rôle --}}
    <div id="assignRoleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 20px 0; color: #1f2937; font-size: 1.5rem;">🎭 Attribuer un Rôle</h3>
            <form action="{{ route('users.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Sélectionner l'utilisateur</label>
                    <select name="user_id" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Choisir un utilisateur...</option>
                        @foreach($tousUtilisateurs ?? [] as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Nouveau rôle</label>
                    <select name="role" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Choisir un rôle...</option>
                        <option value="admin">Administrateur</option>
                        <option value="gestionnaire_compte">Gestionnaire de Compte</option>
                        <option value="gestionnaire_credit">Gestionnaire de Crédit</option>
                        <option value="gest-import">Gestionnaire Import/Export</option>
                        <option value="gest-financement">Gestionnaire Financement</option>
                        <option value="client">Client</option>
                    </select>
                </div>
                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <button type="button" onclick="toggleModal('assignRoleModal')" style="flex: 1; background: #9ca3af; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Annuler
                    </button>
                    <button type="submit" style="flex: 1; background: #3b82f6; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Attribuer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.style.display === 'none' || modal.style.display === '') {
                modal.style.display = 'flex';
            } else {
                modal.style.display = 'none';
            }
        }

        function editUser(userId) {
            window.location.href = `/admin/users/${userId}/edit`;
        }

        function deleteUser(userId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('✅ ' + data.message);
                            location.reload();
                        } else {
                            alert('❌ ' + (data.message || 'Erreur lors de la suppression'));
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('❌ Erreur de connexion');
                    });
            }
        }

        function exportGlobalReport() {
            window.location.href = '/admin/export/global-report';
        }

        // Fermer les modals en cliquant à l'extérieur
        document.getElementById('addAdminModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleModal('addAdminModal');
            }
        });

        document.getElementById('assignRoleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleModal('assignRoleModal');
            }
        });

        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('addAdminModal').style.display = 'none';
                document.getElementById('assignRoleModal').style.display = 'none';
            }
        });
    </script>

</section>
@endsection