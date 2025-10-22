@extends('layouts.home')
@section('content')
<section style="min-height: 100vh; background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); padding: 15px; overflow-y: auto;">

    @if(auth()->user()->role !== 'admin')
    <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin: 20px; color: #dc2626; text-align: center;">
        <h3>Accès non autorisé</h3>
        <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
    </div>
    @else
    <div style="max-width: 1600px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 10px; padding: 15px 20px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h1 style="color: #1a202c; margin: 0; font-size: clamp(1.2rem, 4vw, 1.8rem); font-weight: 700;">🎯 Dashboard Admin</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: clamp(0.85rem, 2vw, 1rem);" class="desktop-only">Vue d'ensemble et gestion du système</p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button onclick="exportGlobalReport()" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; white-space: nowrap;">
                        📊 Export
                    </button>
                    <button onclick="location.reload()" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                        🔄
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques Globales --}}
        <div style="margin-bottom: 15px;">
            <h2 style="color: white; margin: 0 0 10px 5px; font-size: clamp(1rem, 3vw, 1.3rem); font-weight: 600;">📈 Vue d'ensemble</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">

                {{-- Utilisateurs --}}
                <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 700;">{{ $totalUtilisateurs ?? 0 }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.85rem;">Utilisateurs</p>
                        </div>
                        <div style="font-size: 1.5rem;">👥</div>
                    </div>
                </div>

                {{-- Comptes --}}
                <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 700;">{{ $totalComptes ?? 0 }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.85rem;">Comptes</p>
                        </div>
                        <div style="font-size: 1.5rem;">💳</div>
                    </div>
                </div>

                {{-- Crédits --}}
                <div style="background: linear-gradient(135deg, #ec4899, #db2777); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 700;">{{ $totalCredits ?? 0 }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.85rem;">Crédits</p>
                        </div>
                        <div style="font-size: 1.5rem;">💰</div>
                    </div>
                </div>

                {{-- Import/Export --}}
                <div style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 700;">{{ $totalImportExport ?? 0 }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.85rem;">Import/Export</p>
                        </div>
                        <div style="font-size: 1.5rem;">🚢</div>
                    </div>
                </div>

                {{-- Projets --}}
                <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 700;">{{ $totalProjets ?? 0 }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.85rem;">Projets</p>
                        </div>
                        <div style="font-size: 1.5rem;">🎯</div>
                    </div>
                </div>

                {{-- Montant Total --}}
                <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="overflow: hidden;">
                            <h3 style="margin: 0; font-size: clamp(1rem, 3vw, 1.2rem); font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ number_format($montantTotalCredits ?? 0, 0, ',', ' ') }}</h3>
                            <p style="margin: 3px 0 0 0; opacity: 0.9; font-size: 0.75rem;">FCFA</p>
                        </div>
                        <div style="font-size: 1.5rem;">💵</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sections principales --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; margin-bottom: 15px;">

            {{-- Gestion des utilisateurs --}}
            <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 12px 15px;">
                    <h2 style="margin: 0; font-size: 1.1rem; font-weight: 600;">👥 Gestion Utilisateurs</h2>
                </div>
                <div style="padding: 15px;">
                    <button onclick="toggleModal('addAdminModal')" style="width: 100%; background: #10b981; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem; margin-bottom: 10px;">
                        ➕ Ajouter Admin
                    </button>
                    <button onclick="toggleModal('assignRoleModal')" style="width: 100%; background: #3b82f6; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                        🎭 Attribuer Rôle
                    </button>

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e5e7eb; max-height: 250px; overflow-y: auto;">
                        <h3 style="margin: 0 0 10px 0; color: #1f2937; font-size: 0.95rem;">📊 Stats par rôle</h3>
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Admin</span>
                                <span style="color: #6366f1; font-weight: 700;">{{ $statsRoles['admin'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Gest. Compte</span>
                                <span style="color: #8b5cf6; font-weight: 700;">{{ $statsRoles['gestionnaire_compte'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Gest. Crédit</span>
                                <span style="color: #ec4899; font-weight: 700;">{{ $statsRoles['gestionnaire_credit'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Gest. Import</span>
                                <span style="color: #06b6d4; font-weight: 700;">{{ $statsRoles['gest-import'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Gest. Finance</span>
                                <span style="color: #f59e0b; font-weight: 700;">{{ $statsRoles['gest-financement'] ?? 0 }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 8px; background: #f3f4f6; border-radius: 4px; font-size: 0.85rem;">
                                <span style="font-weight: 600;">Clients</span>
                                <span style="color: #10b981; font-weight: 700;">{{ $statsRoles['user'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activité récente --}}
            <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 15px;">
                    <h2 style="margin: 0; font-size: 1.1rem; font-weight: 600;">⚡ Activité Récente</h2>
                </div>
                <div style="padding: 15px; max-height: 350px; overflow-y: auto;">
                    @forelse($activitesRecentes ?? [] as $activite)
                    <div style="padding: 8px; border-left: 3px solid {{ 
            $activite->type === 'user' ? '#6366f1' : 
            ($activite->type === 'compte' ? '#8b5cf6' : 
            ($activite->type === 'credit' ? '#ec4899' : 
            ($activite->type === 'import' ? '#06b6d4' : '#f59e0b'))) 
        }}; background: #f9fafb; margin-bottom: 8px; border-radius: 4px;">
                        <div style="display: flex; align-items: start; gap: 8px;">
                            <span style="font-size: 1rem;">{{ $activite->icon }}</span>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: #1f2937; margin-bottom: 3px; font-size: 0.85rem; overflow: hidden; text-overflow: ellipsis;">{{ $activite->description }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $activite->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 30px; color: #9ca3af;">
                        <div style="font-size: 2rem; margin-bottom: 8px;">📭</div>
                        <p style="font-size: 0.9rem;">Aucune activité récente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tableau utilisateurs --}}
        <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); margin-bottom: 15px;">
            <div style="background: linear-gradient(135deg, #1f2937, #374151); color: white; padding: 12px 15px;">
                <h2 style="margin: 0; font-size: 1.1rem; font-weight: 600;">👤 Tous les Utilisateurs</h2>
            </div>

            {{-- Filtres compacts --}}
            <div style="padding: 12px; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <form method="GET" style="display: flex; flex-wrap: wrap; gap: 8px; align-items: end;">
                    <div style="flex: 1; min-width: 150px;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                            style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.85rem;">
                    </div>
                    <div style="flex: 1; min-width: 120px;">
                        <select name="role" style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.85rem;">
                            <option value="">Tous rôles</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="gestionnaire_compte" {{ request('role') === 'gestionnaire_compte' ? 'selected' : '' }}>Gest. Compte</option>
                            <option value="gestionnaire_credit" {{ request('role') === 'gestionnaire_credit' ? 'selected' : '' }}>Gest. Crédit</option>
                            <option value="gest-import" {{ request('role') === 'gest-import' ? 'selected' : '' }}>Gest. Import</option>
                            <option value="gest-financement" {{ request('role') === 'gest-financement' ? 'selected' : '' }}>Gest. Finance</option>
                            <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; white-space: nowrap;">
                            🔍 Filtrer
                        </button>
                        <a href="{{ route('dashboard') }}" style="background: #9ca3af; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; text-align: center; font-weight: 600; font-size: 0.85rem;">
                            🔄
                        </a>
                    </div>
                </form>
            </div>

            <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                    <thead style="background: #f9fafb; position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="padding: 10px 8px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb; white-space: nowrap;">Utilisateur</th>
                            <th style="padding: 10px 8px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb; white-space: nowrap;">Email</th>
                            <th style="padding: 10px 8px; text-align: left; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb; white-space: nowrap;">Rôle</th>
                            <th style="padding: 10px 8px; text-align: center; font-weight: 600; color: #1f2937; border-bottom: 2px solid #e5e7eb; white-space: nowrap;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs ?? [] as $user)
                        <tr style="border-bottom: 1px solid #e5e7eb;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='white'">
                            <td style="padding: 8px;">
                                <div style="font-weight: 600; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" title="{{ $user->name }}">{{ $user->name }}</div>
                            </td>
                            <td style="padding: 8px;">
                                <div style="color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;" title="{{ $user->email }}">{{ $user->email }}</div>
                            </td>
                            <td style="padding: 8px;">
                                @php
                                $roleColors = [
                                'admin' => 'background: #dbeafe; color: #1e40af;',
                                'gestionnaire_compte' => 'background: #ede9fe; color: #6b21a8;',
                                'gestionnaire_credit' => 'background: #fce7f3; color: #9f1239;',
                                'gest-import' => 'background: #cffafe; color: #155e75;',
                                'gest-financement' => 'background: #fef3c7; color: #92400e;',
                                'client' => 'background: #d1fae5; color: #065f46;'
                                ];
                                $roleLabels = [
                                'admin' => 'Admin',
                                'gestionnaire_compte' => 'G.Compte',
                                'gestionnaire_credit' => 'G.Crédit',
                                'gest-import' => 'G.Import',
                                'gest-financement' => 'G.Finance',
                                'client' => 'Client'
                                ];
                                @endphp
                                <span style="padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; {{ $roleColors[$user->role] ?? 'background: #f3f4f6; color: #4b5563;' }}">
                                    {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                </span>
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center; flex-wrap: wrap;">
                                    <button onclick="editUser({{ $user->id }})" style="background: #3b82f6; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; white-space: nowrap;" title="Modifier">
                                        ✏️
                                    </button>
                                    @if($user->role !== 'admin' || auth()->id() !== $user->id)
                                    <button onclick="deleteUser({{ $user->id }})" style="background: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; white-space: nowrap;" title="Supprimer">
                                        🗑️
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #9ca3af;">
                                <div style="font-size: 2rem; margin-bottom: 10px;">👥</div>
                                <h3 style="margin: 0; color: #374151; font-size: 0.95rem;">Aucun utilisateur trouvé</h3>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($utilisateurs) && $utilisateurs->hasPages())
            <div style="padding: 12px; border-top: 1px solid #e5e7eb; background: #f9fafb;">
                {{ $utilisateurs->links() }}
            </div>
            @endif
        </div>

    </div>
    @endif

    {{-- Modal Ajouter Admin --}}
    <div id="addAdminModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center; padding: 15px; overflow-y: auto;">
        <div style="background: white; border-radius: 12px; padding: 20px; max-width: 450px; width: 100%; max-height: 90vh; overflow-y: auto;">
            <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 1.3rem;">➕ Ajouter Admin</h3>
            <form action="{{ route('users.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                @csrf
                <input type="hidden" name="role" value="admin">
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Nom complet</label>
                    <input type="text" name="name" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Email</label>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Mot de passe</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Confirmer</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                </div>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                    <button type="button" onclick="toggleModal('addAdminModal')" style="flex: 1; background: #9ca3af; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                        Annuler
                    </button>
                    <button type="submit" style="flex: 1; background: #10b981; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Attribuer Rôle --}}
    <div id="assignRoleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center; padding: 15px; overflow-y: auto;">
        <div style="background: white; border-radius: 12px; padding: 20px; max-width: 450px; width: 100%; max-height: 90vh; overflow-y: auto;">
            <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 1.3rem;">🎭 Attribuer Rôle</h3>
            <form action="{{ route('users.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                @csrf
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Utilisateur</label>
                    <select name="user_id" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                        <option value="">Choisir...</option>
                        @foreach($tousUtilisateurs ?? [] as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 0.9rem;">Nouveau rôle</label>
                    <select name="role" required style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 0.9rem;">
                        <option value="">Choisir un rôle...</option>
                        <option value="admin">Administrateur</option>
                        <option value="gestionnaire_compte">Gestionnaire de Compte</option>
                        <option value="gestionnaire_credit">Gestionnaire de Crédit</option>
                        <option value="gest-import">Gestionnaire Import/Export</option>
                        <option value="gest-financement">Gestionnaire Financement</option>
                        <option value="client">Client</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                    <button type="button" onclick="toggleModal('assignRoleModal')" style="flex: 1; background: #9ca3af; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                        Annuler
                    </button>
                    <button type="submit" style="flex: 1; background: #3b82f6; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
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
                document.body.style.overflow = 'hidden';
            } else {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
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
                const modals = ['addAdminModal', 'assignRoleModal'];
                modals.forEach(modalId => {
                    document.getElementById(modalId).style.display = 'none';
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Media queries pour responsive
        if (window.matchMedia('(min-width: 768px)').matches) {
            document.querySelectorAll('.desktop-only').forEach(el => {
                el.style.display = 'block';
            });
        }
    </script>

    <style>
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .desktop-only {
                display: none !important;
            }
        }

        /* Amélioration des boutons sur mobile */
        @media (max-width: 480px) {
            button, a {
                touch-action: manipulation;
            }
        }

        /* Optimisation du tableau sur petits écrans */
        @media (max-width: 768px) {
            table {
                font-size: 0.75rem !important;
            }
            
            th, td {
                padding: 6px 4px !important;
            }
        }

        /* Optimisation des cartes stats sur mobile */
        @media (max-width: 480px) {
            [style*="grid-template-columns: repeat(auto-fit, minmax(140px, 1fr))"] {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)) !important;
            }
        }

        /* Amélioration de la lisibilité sur petits écrans */
        @media (max-width: 640px) {
            body {
                font-size: 14px;
            }
        }

        /* Hover effects pour desktop */
        @media (min-width: 1024px) {
            button:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transition: all 0.3s ease;
            }
        }
    </style>

</section>
@endsection