@extends('layouts.home')
@section('content')
<section style="min-height: 100vh; background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #1a202c; margin: 0; font-size: 2rem; font-weight: 700;">Modifier l'utilisateur</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">Modification des informations de {{ $user->name }}</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" style="background: #9ca3af; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Formulaire de modification --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            
            @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px; color: #991b1b;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                @method('PUT')

                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Rôle</label>
                    <select name="role" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="gestionnaire_compte" {{ old('role', $user->role) === 'gestionnaire_compte' ? 'selected' : '' }}>Gestionnaire de Compte</option>
                        <option value="gestionnaire_credit" {{ old('role', $user->role) === 'gestionnaire_credit' ? 'selected' : '' }}>Gestionnaire de Crédit</option>
                        <option value="gest-import" {{ old('role', $user->role) === 'gest-import' ? 'selected' : '' }}>Gestionnaire Import/Export</option>
                        <option value="gest-financement" {{ old('role', $user->role) === 'gest-financement' ? 'selected' : '' }}>Gestionnaire Financement</option>
                        <option value="client" {{ old('role', $user->role) === 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                    @if(Auth::id() === $user->id)
                    <p style="margin-top: 5px; font-size: 0.85rem; color: #f59e0b;">⚠️ Vous ne pouvez pas modifier votre propre rôle</p>
                    @endif
                </div>

                <div style="border-top: 2px solid #e5e7eb; padding-top: 20px; margin-top: 10px;">
                    <h3 style="margin: 0 0 15px 0; color: #374151;">Changer le mot de passe (optionnel)</h3>
                    <p style="font-size: 0.9rem; color: #6b7280; margin-bottom: 15px;">Laissez vide pour conserver le mot de passe actuel</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nouveau mot de passe</label>
                            <input type="password" name="password" 
                                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" 
                                style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <a href="{{ route('admin.dashboard') }}" style="flex: 1; background: #9ca3af; color: white; padding: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; display: inline-block;">
                        Annuler
                    </a>
                    <button type="submit" style="flex: 1; background: #3b82f6; color: white; border: none; padding: 14px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection