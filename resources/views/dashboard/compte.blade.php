<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte AXE CAPITAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
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
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-6xl mx-auto p-6 space-y-8">
        <!-- En-tête avec statut -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden">
            <!-- Motif décoratif de fond -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-20 -translate-y-20"></div>
                <div class="absolute bottom-0 right-0 w-60 h-60 bg-white rounded-full translate-x-20 translate-y-20"></div>
            </div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <h1 class="text-4xl font-bold mb-2 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        Mon Compte AXE CAPITAL
                    </h1>
                    <p class="text-indigo-100 text-lg font-medium" id="nom-complet">{{ $compte->nom_complet }}</p>
                    <p class="text-indigo-200 text-sm mt-1">Membre depuis <span id="date-creation">{{ $compte->created_at->format('F Y') }}</span></p>
                </div>
                <div class="text-right">
                    <div id="status-indicator" class="glass-effect border rounded-xl px-6 py-3 mb-3">
                        <div class="flex items-center space-x-3">
                            <div id="status-dot" class="w-4 h-4 rounded-full"></div>
                            <span id="status-text" class="font-semibold text-lg"></span>
                        </div>
                    </div>
                    <p id="status-description" class="text-sm text-indigo-200"></p>
                </div>
            </div>
        </div>

        <!-- Message de confirmation -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 rounded-r-2xl p-6 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-green-800">Compte créé avec succès !</h3>
                    <p class="text-green-700 mt-1">Votre demande d'ouverture de compte a été enregistrée.</p>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations personnelles -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Mes Informations
                    </h2>
                </div>

                <form action="{{ route('compte.update', $compte->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Nom
                            </label>
                            <input type="text" name="nom" value="{{ $compte->nom }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre nom">
                        </div>

                        <!-- Prénom -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Prénom
                            </label>
                            <input type="text" name="prenom" value="{{ $compte->prenom }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre prénom">
                        </div>

                        <!-- Téléphone -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                Téléphone
                            </label>
                            <input type="text" name="telephone" value="{{ $compte->telephone }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre téléphone">
                        </div>

                        <!-- Ville -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                Ville
                            </label>
                            <input type="text" name="ville" value="{{ $compte->ville }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre ville">
                        </div>

                        <!-- Quartier -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                </div>
                                Quartier
                            </label>
                            <input type="text" name="quartier" value="{{ $compte->quartier }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre quartier">
                        </div>

                        <!-- Pays -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                                    </svg>
                                </div>
                                Pays
                            </label>
                            <input type="text" name="pays" value="{{ $compte->pays }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre pays">
                        </div>

                        <!-- Lieu-dit -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                </div>
                                Lieu-dit
                            </label>
                            <input type="text" name="lieudit" value="{{ $compte->lieudit }}" 
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300"
                                placeholder="Saisissez votre lieu-dit">
                        </div>

                        <!-- Sexe -->
                        <div class="group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                <div class="w-5 h-5 bg-indigo-100 rounded-md flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Sexe
                            </label>
                            <select name="sexe" class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 group-hover:border-indigo-300">
                                <option value="Homme" {{ $compte->sexe === 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ $compte->sexe === 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 pt-6 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-blue-700 focus:ring-4 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Sidebar avec informations complémentaires -->
            <div class="space-y-6">
                <!-- Statut détaillé -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div id="status-header" class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <div id="status-icon-container" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3">
                                <svg id="status-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Statut du compte
                        </h3>
                    </div>

                    <div class="p-6">
                        <div id="status-card" class="border rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <div id="status-dot-sidebar" class="w-4 h-4 rounded-full mr-3"></div>
                                <span id="status-text-sidebar" class="font-semibold text-lg"></span>
                            </div>
                            <p id="status-description-sidebar" class="text-sm leading-relaxed mb-3"></p>
                            <div id="status-info" class="rounded-lg p-3">
                                <p class="text-xs">
                                    <strong>Date de création :</strong> <span id="date-creation-detail">{{ $compte->created_at->format('d/m/Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations du compte -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Informations importantes
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Date de création</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $compte->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Numéro CNI</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $compte->cni }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Contact d'urgence</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $compte->contact_urgence }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration du statut dynamique basé sur les données Laravel
        document.addEventListener('DOMContentLoaded', function() {
            // Simuler la variable PHP $compte->status
            // Dans votre vraie application, cette valeur viendra directement de PHP
            const compteStatus = '{{ $compte->status ?? "inactif" }}';
            
            updateStatusDisplay(compteStatus);
        });

        function updateStatusDisplay(status) {
            const statusIndicator = document.getElementById('status-indicator');
            const statusDot = document.getElementById('status-dot');
            const statusText = document.getElementById('status-text');
            const statusDescription = document.getElementById('status-description');
            
            // Sidebar elements
            const statusHeader = document.getElementById('status-header');
            const statusIconContainer = document.getElementById('status-icon-container');
            const statusIcon = document.getElementById('status-icon');
            const statusCard = document.getElementById('status-card');
            const statusDotSidebar = document.getElementById('status-dot-sidebar');
            const statusTextSidebar = document.getElementById('status-text-sidebar');
            const statusDescriptionSidebar = document.getElementById('status-description-sidebar');
            const statusInfo = document.getElementById('status-info');

            if (status === 'inactif') {
                // Header status
                statusIndicator.className = 'status-pending glass-effect border border-yellow-300/30 rounded-xl px-6 py-3 mb-3';
                statusDot.className = 'w-4 h-4 bg-yellow-400 rounded-full animate-pulse';
                statusText.className = 'text-yellow-100 font-semibold text-lg';
                statusText.textContent = 'En validation';
                statusDescription.textContent = 'Compte en cours d\'examen';

                // Sidebar status
                statusHeader.className = 'bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b border-yellow-100';
                statusIconContainer.className = 'w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3';
                statusIcon.className = 'w-5 h-5 text-yellow-600';
                statusIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                
                statusCard.className = 'bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-4';
                statusDotSidebar.className = 'w-4 h-4 bg-yellow-400 rounded-full mr-3 animate-pulse';
                statusTextSidebar.className = 'font-semibold text-yellow-800 text-lg';
                statusTextSidebar.textContent = 'En cours de validation';
                statusDescriptionSidebar.className = 'text-sm text-yellow-700 leading-relaxed mb-3';
                statusDescriptionSidebar.textContent = 'Votre compte est actuellement examiné par nos équipes. Vous recevrez une notification dès l\'activation.';
                statusInfo.className = 'bg-white/50 rounded-lg p-3';
                statusInfo.innerHTML = '<p class="text-xs text-yellow-600"><strong>Délai estimé :</strong> 24-48h ouvrées</p>';
                
            } else {
                // Header status (actif)
                statusIndicator.className = 'status-active glass-effect border border-green-300/30 rounded-xl px-6 py-3 mb-3';
                statusDot.className = 'w-4 h-4 bg-green-300 rounded-full animate-pulse';
                statusText.className = 'text-green-100 font-semibold text-lg';
                statusText.textContent = 'Actif';
                statusDescription.textContent = 'Compte opérationnel';

                // Sidebar status (actif)
                statusHeader.className = 'bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-100';
                statusIconContainer.className = 'w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3';
                statusIcon.className = 'w-5 h-5 text-green-600';
                statusIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                
                statusCard.className = 'bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4';
                statusDotSidebar.className = 'w-4 h-4 bg-green-400 rounded-full mr-3';
                statusTextSidebar.className = 'font-semibold text-green-800 text-lg';
                statusTextSidebar.textContent = 'Compte actif';
                statusDescriptionSidebar.className = 'text-sm text-green-700 leading-relaxed mb-3';
                statusDescriptionSidebar.textContent = 'Votre compte est opérationnel. Vous pouvez effectuer toutes les opérations bancaires.';
                statusInfo.className = 'bg-white/70 rounded-lg p-3';
                statusInfo.innerHTML = '<p class="text-xs text-green-600"><strong>Dernière vérification :</strong> {{ date("d/m/Y") }}</p>';
            }
        }

        // Gestion de la soumission du formulaire
        document.querySelector('form').addEventListener('submit', function(event) {
            // Pour la démo, on empêche la soumission réelle
            // Dans votre vraie application, laissez le formulaire se soumettre normalement
            // event.preventDefault();
            
            // Animation de succès
            const button = event.target.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            button.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Mise à jour...
            `;
            
            // Simulation d'un délai de traitement
            setTimeout(() => {
                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Mis à jour !
                `;
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                button.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-blue-600');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-blue-600');
                }, 2000);
            }, 1500);
        });

        // Validation en temps réel des champs
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('border-green-300', 'bg-green-50');
                    this.classList.remove('border-gray-200', 'bg-gray-50');
                } else {
                    this.classList.remove('border-green-300', 'bg-green-50');
                    this.classList.add('border-gray-200', 'bg-gray-50');
                }
            });

            // Vérification initiale
            if (input.value.trim() !== '') {
                input.classList.add('border-green-300', 'bg-green-50');
                input.classList.remove('border-gray-200', 'bg-gray-50');
            }
        });

        // Animation d'entrée pour les cartes
        function animateCards() {
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Lancer l'animation au chargement
        setTimeout(animateCards, 300);
    </script>
</body>
</html>