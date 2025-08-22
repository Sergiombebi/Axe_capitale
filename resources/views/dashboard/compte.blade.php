{{-- Section à placer dans @section('content') - SANS JAVASCRIPT --}}
<style>
    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
    }

    .animate-pulse-slow {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .form-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.1);
    }

    .status-active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .status-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    /* Animation CSS pure pour l'entrée des cartes */
    .card-animate {
        animation: slideInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .card-animate:nth-child(1) {
        animation-delay: 0.1s;
    }

    .card-animate:nth-child(2) {
        animation-delay: 0.2s;
    }

    .card-animate:nth-child(3) {
        animation-delay: 0.3s;
    }

    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Styles pour les champs validés (simulation) */
    .form-input:valid {
        border-color: #10b981;
        background-color: #f0fdf4;
    }

    /* États des statuts */
    .status-inactive .status-dot {
        background-color: #f59e0b;
        animation: pulse 2s infinite;
    }

    .status-inactive .status-text {
        color: #fbbf24;
    }

    .status-inactive .status-description {
        color: #d97706;
    }

    .status-active .status-dot {
        background-color: #10b981;
    }

    .status-active .status-text {
        color: #10b981;
    }

    .status-active .status-description {
        color: #059669;
    }
</style>

<div class="space-y-8">
    <!-- En-tête avec statut -->
    <!-- Message de succès -->
    <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-xl shadow-lg p-4 mb-6 border border-green-300">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-black">Compte créé avec succès !</h3>
                <p class="text-green-700 text-sm">Votre demande d'ouverture de compte a été enregistrée.</p>
            </div>
        </div>
    </div>

    <!-- Carte principale stylisée comme l'image -->
    <div class="shadow-2xl p-8 relative overflow-hidden" style="background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 50%, #9333ea 100%); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 24px;">
        <!-- Cercles décoratifs flous -->
        <div class="absolute top-0 left-0" style="width: 12rem; height: 12rem; background: rgba(255, 255, 255, 0.1); filter: blur(60px); transform: translate(-50%, -50%); border-radius: 50%;"></div>
        <div class="absolute bottom-0 right-0" style="width: 16rem; height: 16rem; background: rgba(236, 72, 153, 0.15); filter: blur(60px); transform: translate(33%, 33%); border-radius: 50%;"></div>
        <div class="absolute" style="width: 8rem; height: 8rem; background: rgba(139, 92, 246, 0.1); filter: blur(40px); top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 50%;"></div>

        <!-- Contenu principal -->
        <div class="flex items-center justify-between relative z-10">
            <div>
                <h1 style="font-size: 2.25rem; font-weight: 700; color: white; margin-bottom: 0.5rem; text-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">Mon Compte AXE CAPITAL</h1>
                <p style="color: rgba(255, 255, 255, 0.95); font-size: 1.125rem; font-weight: 600;">{{ $compte->nom ?? 'Nom complet' }}</p>
                <p style="color: rgba(255, 255, 255, 0.75); font-size: 0.875rem; margin-top: 0.25rem;">Membre depuis <span style="font-weight: 500;">{{ $compte->created_at->format('F Y') ?? 'Janvier 2025' }}</span></p>
            </div>
            <div class="text-right">
                @if(($compte->status ?? 'inactif') === 'inactif')
                <!-- Statut orange/jaune comme dans l'interface -->
                <div class="inline-flex items-center shadow-lg" style="background: linear-gradient(90deg, #f97316 0%, #f59e0b 100%); color: white; font-weight: 600; padding: 0.75rem 1.5rem; gap: 0.5rem; border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 16px;">
                    <div class="animate-pulse" style="width: 0.625rem; height: 0.625rem; background: #fef3c7; box-shadow: 0 1px 2px rgba(0,0,0,0.1); border-radius: 50%;"></div>
                    <span style="font-size: 0.875rem; font-weight: 500;">En validation</span>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.8); margin-top: 0.5rem; font-weight: 500;">Compte en cours d'examen</p>
                @else
                <!-- Statut vert modernisé -->
                <div class="inline-flex items-center shadow-lg" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 0.75rem 1.5rem; gap: 0.5rem; border: 1px solid rgba(52, 211, 153, 0.3); border-radius: 16px;">
                    <div class="rounded-full" style="width: 0.625rem; height: 0.625rem; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.1);"></div>
                    <span style="font-size: 0.875rem; font-weight: 500;">Actif</span>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.8); margin-top: 0.5rem; font-weight: 500;">Compte opérationnel</p>
                @endif
            </div>
        </div>
    </div>


    <!-- Contenu principal -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div style="grid-column: 1 / -1;">
            <!-- Informations personnelles -->
            <div style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
                <div style="background: linear-gradient(90deg, #f8fafc 0%, #e0e7ff 100%); padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; margin: 0;">
                        <div style="width: 2rem; height: 2rem; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Mes Informations
                    </h2>
                </div>

                <form action="{{ route('compte.update', $compte->id) }}" method="POST" enctype="multipart/form-data" style="padding: 2rem;">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                        <!-- Nom -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Nom
                            </label>
                            <input type="text" name="nom" value="{{ $compte->nom ?? '' }}" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre nom"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Prénom
                            </label>
                            <input type="text" name="prenom" value="{{ $compte->prenom ?? '' }}" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre prénom"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                Téléphone
                            </label>
                            <input type="tel" name="telephone" value="{{ $compte->telephone ?? '' }}" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre téléphone"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Ville -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                Ville
                            </label>
                            <input type="text" name="ville" value="{{ $compte->ville ?? '' }}" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre ville"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Quartier -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                </div>
                                Quartier
                            </label>
                            <input type="text" name="quartier" value="{{ $compte->quartier ?? '' }}"
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre quartier"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Pays -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                                    </svg>
                                </div>
                                Pays
                            </label>
                            <input type="text" name="pays" value="{{ $compte->pays ?? '' }}" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre pays"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Lieu-dit -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                </div>
                                Lieu-dit
                            </label>
                            <input type="text" name="lieudit" value="{{ $compte->lieudit ?? '' }}"
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                placeholder="Saisissez votre lieu-dit"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        </div>

                        <!-- Sexe -->
                        <div>
                            <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
                                <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                                    <svg style="width: 0.75rem; height: 0.75rem; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Sexe
                            </label>
                            <select name="sexe" required
                                style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none;"
                                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                                <option value="">Sélectionnez votre sexe</option>
                                <option value="Homme" {{ ($compte->sexe ?? '') === 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ ($compte->sexe ?? '') === 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
                        <button type="submit"
                            style="display: inline-flex; align-items: center; padding: 0.75rem 2rem; background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%); color: white; font-weight: 600; border-radius: 16px; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); transition: all 0.2s; outline: none;"
                            onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 25px -5px rgba(79, 70, 229, 0.4)'"
                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(79, 70, 229, 0.3)'">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar réorganisée avec responsive -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1rem;">

            <!-- Statut du compte -->
            <div style="background: white; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;">
                @if(($compte->status ?? 'inactif') === 'inactif')
                <div style="background: linear-gradient(90deg, #fef3c7 0%, #fed7aa 100%); padding: 1.5rem; border-bottom: 1px solid #fbbf24;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; margin: 0;">
                        <div style="width: 2rem; height: 2rem; background: #fbbf24; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: #92400e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Statut du compte
                    </h3>
                </div>

                <div style="padding: 1.5rem;">
                    <div style="background: linear-gradient(90deg, #fef3c7 0%, #fed7aa 100%); border: 1px solid #fbbf24; border-radius: 16px; padding: 1rem;">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <div style="width: 1rem; height: 1rem; background: #fbbf24; border-radius: 50%; margin-right: 0.75rem;">
                                <style>
                                    @keyframes pulse {

                                        0%,
                                        100% {
                                            opacity: 1;
                                        }

                                        50% {
                                            opacity: 0.5;
                                        }
                                    }

                                    .pulse-animation {
                                        animation: pulse 2s infinite;
                                    }
                                </style>
                                <div class="pulse-animation" style="width: 100%; height: 100%; background: #fbbf24; border-radius: 50%;"></div>
                            </div>
                            <span style="font-weight: 600; color: #92400e; font-size: 1.125rem;">En cours de validation</span>
                        </div>
                        <p style="font-size: 0.875rem; color: #92400e; line-height: 1.6; margin-bottom: 0.75rem; margin: 0 0 0.75rem 0;">
                            Votre compte est actuellement examiné par nos équipes. Vous recevrez une notification dès l'activation.
                        </p>
                        <div style="background: rgba(255, 255, 255, 0.5); border-radius: 12px; padding: 0.75rem;">
                            <p style="font-size: 0.75rem; color: #92400e; margin: 0;">
                                <strong>Délai estimé :</strong> 24-48h ouvrées
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div style="background: linear-gradient(90deg, #d1fae5 0%, #a7f3d0 100%); padding: 1.5rem; border-bottom: 1px solid #10b981;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; margin: 0;">
                        <div style="width: 2rem; height: 2rem; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Statut du compte
                    </h3>
                </div>

                <div style="padding: 1.5rem;">
                    <div style="background: linear-gradient(90deg, #d1fae5 0%, #a7f3d0 100%); border: 1px solid #10b981; border-radius: 16px; padding: 1rem;">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <div style="width: 1rem; height: 1rem; background: #10b981; border-radius: 50%; margin-right: 0.75rem;"></div>
                            <span style="font-weight: 600; color: #065f46; font-size: 1.125rem;">Compte actif</span>
                        </div>
                        <p style="font-size: 0.875rem; color: #065f46; line-height: 1.6; margin: 0 0 0.75rem 0;">
                            Votre compte est opérationnel. Vous pouvez effectuer toutes les opérations bancaires.
                        </p>
                        <div style="background: rgba(255, 255, 255, 0.7); border-radius: 12px; padding: 0.75rem;">
                            <p style="font-size: 0.75rem; color: #065f46; margin: 0;">
                                <strong>Dernière vérification :</strong> {{ date('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Informations importantes -->
            <div style="background: white; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <div style="background: linear-gradient(90deg, #dbeafe 0%, #e0e7ff 100%); padding: 1.5rem; border-bottom: 1px solid #3b82f6;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; margin: 0;">
                        <div style="width: 2rem; height: 2rem; background: #3b82f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Informations importantes
                    </h3>
                </div>

                <div style="padding: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f9fafb; border-radius: 12px; flex-wrap: wrap; gap: 0.5rem;">
                            <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Date de création</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #1f2937;">{{ $compte->created_at->format('d/m/Y') ?? date('d/m/Y') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f9fafb; border-radius: 12px; flex-wrap: wrap; gap: 0.5rem;">
                            <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Numéro CNI</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #1f2937;">{{ $compte->cni ?? '***-***-***' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f9fafb; border-radius: 12px; flex-wrap: wrap; gap: 0.5rem;">
                            <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Contact d'urgence</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #1f2937;">{{ $compte->contact_urgence ?? 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Bloc principal -->
            <div style="background: white; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <!-- Titre -->
                <div style="background: linear-gradient(90deg, #fae8ff 0%, #fce7f3 100%); padding: 1.5rem; border-bottom: 1px solid #a855f7;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; margin: 0;">
                        <div style="width: 2rem; height: 2rem; background: #a855f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        Solde du compte d'epargne
                    </h3>
                </div>

                <!-- Affichage du solde -->
                <div style="padding: 1.5rem; text-align: center;">
                    <p style="font-size: 1.5rem; font-weight: bold; color: #6b21a8; margin: 0;">
                        {{ number_format($compte->solde, 0, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>

            <!-- bloc autre compte -->
           
            <!-- JavaScript -->
            <script>
                let code = '';
                let visible = false;

                function genererCodeSecret() {
                    if (code !== '') return; // Évite de régénérer

                    const lettres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    const chiffres = "0123456789";

                    for (let i = 0; i < 4; i++) {
                        code += lettres.charAt(Math.floor(Math.random() * lettres.length));
                    }
                    for (let i = 0; i < 2; i++) {
                        code += chiffres.charAt(Math.floor(Math.random() * chiffres.length));
                    }

                    // Affiche le code en mode masqué
                    document.getElementById("codeSecret").innerText = "••••••";
                    document.getElementById("codeContainer").style.display = "block";

                    // Désactiver le bouton
                    const btn = document.getElementById("btnGenerer");
                    btn.disabled = true;
                    btn.style.opacity = 0.5;
                    btn.style.cursor = "not-allowed";
                }

                function toggleVisibility() {
                    visible = !visible;
                    document.getElementById("codeSecret").innerText = visible ? code : "••••••";
                }
            </script>
        </div>
     
    </div>
    @include('dashboard.compte-bloque-terme-collectif')
</div>