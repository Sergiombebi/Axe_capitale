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





@if($dejaCree)

@include('dashboard.compte')

@else

<!-- EN-TÊTE -->
<div class="bg-white p-6 sm:p-8 border-b border-gray-100">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Création de compte</h1>
            <p class="text-gray-500 mt-1">Accédez à votre espace AXE CAPITAL</p>
        </div>
        <div class="hidden sm:flex items-center space-x-2">
            <div class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4z" />
                </svg>
            </div>
            <span class="font-medium text-gray-700">AXE CAPITAL</span>
        </div>
    </div>

    <!-- MESSAGE ENCOURAGEMENT -->
    <div id="stepMessage" class="mt-4 text-sm text-blue-600 font-medium transition-all duration-300">
        Bienvenue, remplissez vos informations personnelles.
    </div>

    <!-- BARRE DE PROGRESSION -->
    <div class="mt-6">
        <div class="flex justify-between text-sm text-gray-500 mb-2">
            <span class="step-indicator">Informations</span>
            <span class="step-indicator">Coordonnées</span>
            <span class="step-indicator">Contact</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
        </div>
    </div>
</div>



<!-- FORMULAIRE -->
<form id="multiStepForm" action="{{ route('compte.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- ÉTAPE 1 -->
    <div class="step step-1 space-y-6">
        <h2 class="text-lg font-medium text-gray-900">Identité personnelle</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <input type="date" name="date_naissance" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                <input type="text" name="lieu_naissance" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Numéro CNI</label>
                <input type="text" name="cni" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Photo CNI</label>
                <input type="file" name="photo_cni" class="w-full px-4 py-2 border border-gray-300 rounded-lg" accept="image/*" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Sexe</label>
                <select name="sexe" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Sélectionnez</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
        </div>
    </div>

    <!-- ÉTAPE 2 -->
    <div class="step step-2 hidden space-y-6">
        <h2 class="text-lg font-medium text-gray-900">Coordonnées</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="tel" name="telephone" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Pays</label>
                <input type="text" name="pays" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Ville</label>
                <input type="text" name="ville" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Quartier</label>
                <input type="text" name="quartier" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Lieu-dit (optionnel)</label>
                <input type="text" name="lieudit" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
        </div>
    </div>

    <!-- ÉTAPE 3 -->
    <div class="step step-3 hidden space-y-6">
        <h2 class="text-lg font-medium text-gray-900">Contact d'urgence</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Personne à contacter</label>
                <input type="text" name="contact_urgence" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Téléphone d'urgence</label>
                <input type="tel" name="tel_urgence" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Fait le</label>
                <input type="date" name="fait_le" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">À (lieu)</label>
                <input type="text" name="fait_a" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
        </div>
    </div>

    <!-- NAVIGATION -->
    <div class="flex justify-between pt-4 border-t border-gray-200">
        <button type="button" id="prevStep" class="hidden px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            ⬅️ Précédent
        </button>
        <button type="button" id="nextStep" class="ml-auto px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Suivant ➡️
        </button>
    </div>
</form>

@endif
<!-- SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentStep = 1;
        const totalSteps = 3;
        const progressBar = document.getElementById('progressBar');
        const stepMessage = document.getElementById('stepMessage');
        const messages = {
            1: "Bienvenue, remplissez vos informations personnelles.",
            2: "Courage, vous y êtes presque !",
            3: "Dernière étape ! On y est presque 🎉"
        };

        function showStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
            document.querySelector(`.step-${step}`).classList.remove('hidden');

            progressBar.style.width = `${(step / totalSteps) * 100}%`;
            stepMessage.textContent = messages[step];

            document.querySelectorAll('.step-indicator').forEach((el, idx) => {
                el.classList.toggle('text-blue-600', idx + 1 === step);
                el.classList.toggle('font-medium', idx + 1 === step);
            });

            document.getElementById('prevStep').classList.toggle('hidden', step === 1);
            document.getElementById('nextStep').textContent = step === totalSteps ? 'Terminer ✅' : 'Suivant ➡️';
        }

        document.getElementById('nextStep').addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            } else {
                const nextBtn = document.getElementById('nextStep');
                nextBtn.disabled = true;
                nextBtn.textContent = "Envoi en cours... ⏳";

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