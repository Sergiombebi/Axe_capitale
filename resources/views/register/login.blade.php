@extends('layouts.home')

@section('content')
<div class="w-full max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg mt-8">
    <h2 class="text-2xl font-bold text-center mb-6">Créer un compte</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registrationForm">
        @csrf

        {{-- Nom --}}
        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input type="text" name="name" id="name" required
                    class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- telephone --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">telephone</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input type="text" name="phone" id="phone" required
                    class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" required
                    class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Mot de passe --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" name="password" id="password" required
                    class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                    <svg class="h-5 w-5 text-gray-400" id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div id="password-requirements" class="mt-2 text-sm">
                <p class="text-gray-600 mb-1">Le mot de passe doit contenir :</p>
                <ul class="space-y-1">
                    <li id="length-req" class="flex items-center text-red-500">
                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Au moins 4 caractères
                    </li>
                    <li id="special-req" class="flex items-center text-red-500">
                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Au moins un caractère spécial (!@#$%^&*)
                    </li>
                </ul>
            </div>
        </div>

        {{-- Confirmation du mot de passe --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                    <svg class="h-5 w-5 text-gray-400" id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div id="password-match" class="mt-1 text-sm text-red-500 hidden">
                Les mots de passe ne correspondent pas
            </div>
        </div>

        {{-- Bouton d'inscription --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('login')}}" class="text-blue-600 text-sm hover:underline">
                Vous avez déjà un compte ?
            </a>
            <button type="submit" id="submit-btn"
                class="bg-gray-400 text-white px-6 py-2 rounded transition hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed">
                S'inscrire
            </button>
        </div>
    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');

        if (field.type === 'password') {
            field.type = 'text';
            eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m0 0l3.121-3.121M12 12v6"/>
        `;
        } else {
            field.type = 'password';
            eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
        }
    }

    function validatePassword() {
        const password = document.getElementById('password').value;
        const lengthReq = document.getElementById('length-req');
        const specialReq = document.getElementById('special-req');

        let isValid = true;

        // Vérifier la longueur (minimum 4 caractères)
        if (password.length >= 4) {
            lengthReq.className = 'flex items-center text-green-500';
            lengthReq.innerHTML = `
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Au moins 4 caractères
        `;
        } else {
            lengthReq.className = 'flex items-center text-red-500';
            lengthReq.innerHTML = `
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            Au moins 4 caractères
        `;
            isValid = false;
        }

        // Vérifier les caractères spéciaux
        const specialChars = /[!@#$%^&*(),.?":{}|<>]/;
        if (specialChars.test(password)) {
            specialReq.className = 'flex items-center text-green-500';
            specialReq.innerHTML = `
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Au moins un caractère spécial (!@#$%^&*)
        `;
        } else {
            specialReq.className = 'flex items-center text-red-500';
            specialReq.innerHTML = `
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            Au moins un caractère spécial (!@#$%^&*)
        `;
            isValid = false;
        }

        return isValid;
    }

    function validatePasswordMatch() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const matchDiv = document.getElementById('password-match');

        if (passwordConfirmation && password !== passwordConfirmation) {
            matchDiv.classList.remove('hidden');
            return false;
        } else {
            matchDiv.classList.add('hidden');
            return true;
        }
    }

    function updateSubmitButton() {
        const isPasswordValid = validatePassword();
        const isPasswordMatch = validatePasswordMatch();
        const submitBtn = document.getElementById('submit-btn');

        if (isPasswordValid && isPasswordMatch) {
            submitBtn.disabled = false;
            submitBtn.className = 'bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition';
        } else {
            submitBtn.disabled = true;
            submitBtn.className = 'bg-gray-400 text-white px-6 py-2 rounded transition disabled:cursor-not-allowed';
        }
    }

    // Événements pour la validation en temps réel
    document.getElementById('password').addEventListener('input', updateSubmitButton);
    document.getElementById('password_confirmation').addEventListener('input', updateSubmitButton);

    // Validation avant soumission
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        if (!validatePassword() || !validatePasswordMatch()) {
            e.preventDefault();
            alert('Veuillez corriger les erreurs dans le formulaire avant de continuer.');
        }
    });
</script>
@endsection