@extends('layouts.home')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Informations sur le Compte</h2>

        <ul class="space-y-4 text-gray-700">
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-semibold">•</span>
                L’ouverture du compte à <strong>AXE CAPITAL</strong> est <span class="text-green-600 font-bold">gratuit</span>.
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-semibold">•</span>
                Le solde minimal à déposer dans le compte est de <span class="font-bold text-gray-900">500 FCFA</span>.
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-semibold">•</span>
                Les frais d’entretien du compte s’élèvent à <span class="font-bold text-gray-900">1000 FCFA</span> par trimestre (chaque 3 mois).
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-semibold">•</span>
                Les frais de clôture de compte sont de <span class="font-bold text-gray-900">200 FCFA</span>.
            </li>
        </ul>

        <div class="mt-6 p-4 border-l-4 border-yellow-400 bg-yellow-100 text-yellow-800">
            <strong>NB :</strong> En ce qui concerne le fonctionnement du compte, celui-ci s’active après avoir effectué au moins <span class="font-bold">3000 FCFA</span> d’épargne.
        </div>
    </div>
</div>

<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
  <div class="w-full max-w-2xl">
    <!-- Carte avec effet de profondeur -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
      <!-- En-tête élégant -->
      <div class="bg-white border-b border-gray-100 p-6 sm:p-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Création de compte</h1>
            <p class="text-gray-500 mt-1">Accédez à votre espace AXE CAPITAL</p>
          </div>
          <div class="hidden sm:block">
            <div class="flex items-center space-x-2">
              <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <span class="font-medium text-gray-700">AXE CAPITAL</span>
            </div>
          </div>
        </div>

        <!-- Barre de progression minimaliste -->
        <div class="mt-6">
          <div class="flex justify-between text-sm text-gray-500 mb-2">
            <span class="text-blue-600 font-medium">Informations</span>
            <span>Coordonnées</span>
            <span>Contact</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-1.5">
            <div id="progressBar" class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" style="width: 33%"></div>
          </div>
        </div>
      </div>

      <!-- Formulaire -->
      <form id="multiStepForm" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
        <!-- Étape 1 -->
        <div class="step step-1 space-y-6">
          <div class="space-y-1">
            <h2 class="text-lg font-medium text-gray-900">Identité personnelle</h2>
            <p class="text-sm text-gray-500">Tous les champs sont obligatoires</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nom -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Nom</label>
              <div class="relative">
                <input type="text" name="nom" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Votre nom" required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Prénom -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Prénom</label>
              <input type="text" name="prenom" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Votre prénom" required>
            </div>

            <!-- Date de naissance -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
              <div class="relative">
                <input type="date" name="date_naissance" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Lieu de naissance -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
              <input type="text" name="lieu_naissance" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- CNI -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Numéro CNI</label>
              <input type="text" name="cni" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- Photo CNI -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Photo CNI</label>
              <div class="flex items-center justify-center w-full">
                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-500 mt-2">Glissez-déposez ou cliquez pour uploader</p>
                  </div>
                  <input type="file" name="photo_cni" class="hidden" accept="image/*" required>
                </label>
              </div>
            </div>

            <!-- Sexe -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Sexe</label>
              <select name="sexe" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
                <option value="">Sélectionnez</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Étape 2 (masquée initialement) -->
        <div class="step step-2 hidden space-y-6">
          <div class="space-y-1">
            <h2 class="text-lg font-medium text-gray-900">Vos coordonnées</h2>
            <p class="text-sm text-gray-500">Où pouvons-nous vous joindre ?</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Téléphone -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Téléphone*</label>
              <div class="relative">
                <input type="tel" name="telephone" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="+225..." required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Pays -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Pays*</label>
              <select name="pays" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
                <option value="">Sélectionnez</option>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="France">France</option>
                <option value="Autre">Autre</option>
              </select>
            </div>

            <!-- Ville -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Ville*</label>
              <input type="text" name="ville" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- Quartier -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Quartier*</label>
              <input type="text" name="quartier" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- Lieu-dit -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Lieu-dit <span class="text-gray-400">(Optionnel)</span></label>
              <input type="text" name="lieudit" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
          </div>
        </div>

        <!-- Étape 3 (masquée initialement) -->
        <div class="step step-3 hidden space-y-6">
          <div class="space-y-1">
            <h2 class="text-lg font-medium text-gray-900">Contact d'urgence</h2>
            <p class="text-sm text-gray-500">Qui contacter en cas de besoin ?</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Personne à contacter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Personne*</label>
              <input type="text" name="contact_urgence" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Nom complet" required>
            </div>

            <!-- Téléphone urgence -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Téléphone*</label>
              <input type="tel" name="tel_urgence" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- Fait le -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Fait le*</label>
              <input type="date" name="fait_le" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>

            <!-- À (lieu) -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">À (lieu)*</label>
              <input type="text" name="fait_a" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition" required>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-between pt-4">
          <button type="button" id="prevStep" class="hidden px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
            Précédent
          </button>
          <button type="button" id="nextStep" class="ml-auto px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
            Suivant
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  let currentStep = 1;
  const totalSteps = 3;
  const progressBar = document.getElementById('progressBar');

  const showStep = (step) => {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    document.querySelector(`.step-${step}`).classList.remove('hidden');
    
    // Mise à jour de la barre de progression
    progressBar.style.width = `${(step / totalSteps) * 100}%`;
    
    // Mise à jour des indicateurs d'étape
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
      if (index + 1 === step) {
        indicator.classList.add('text-blue-600', 'font-medium');
        indicator.classList.remove('text-gray-500');
      } else {
        indicator.classList.remove('text-blue-600', 'font-medium');
        indicator.classList.add('text-gray-500');
      }
    });

    // Gestion des boutons
    document.getElementById('prevStep').classList.toggle('hidden', step === 1);
    document.getElementById('nextStep').textContent = step === totalSteps ? 'Terminer' : 'Suivant';
  };

  document.getElementById('nextStep').addEventListener('click', () => {
    if (currentStep < totalSteps) {
      currentStep++;
      showStep(currentStep);
    } else {
      document.getElementById('multiStepForm').submit();
    }
  });

  document.getElementById('prevStep').addEventListener('click', () => {
    if (currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);
});
</script>
@endsection