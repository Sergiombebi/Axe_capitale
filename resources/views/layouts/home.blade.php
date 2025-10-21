<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Axe Capital') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styles pour la sidebar et navbar fixes */
        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 40;
            transition: transform 0.3s ease-in-out;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 30;
            transition: all 0.3s ease-in-out;
        }

        .content-area {
            transition: margin 0.3s ease-in-out;
        }

        /* Mobile: sidebar cachée par défaut */
        @media (max-width: 767px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }

            .sidebar-mobile.show {
                transform: translateX(0);
            }
        }

        /* Desktop: sidebar toujours visible */
        @media (min-width: 768px) {
            .sidebar-mobile {
                transform: translateX(0) !important;
            }
        }

        /* Overlay pour mobile */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 35;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Scroll personnalisé pour la sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">
    {{-- Overlay pour mobile --}}
    <div class="overlay md:hidden" id="overlay"></div>

    <div class="flex min-h-screen">
        {{-- SIDEBAR FIXE --}}
        <aside class="sidebar-fixed w-64 bg-white shadow-lg border-r border-gray-200 sidebar-mobile md:translate-x-0" id="sidebar">
            <div class="flex flex-col h-full">
                {{-- Header de la sidebar --}}
                <div class="p-6 border-b border-gray-100">
                    {{-- Logo --}}
                    <a href="{{route('welcome')}}" class="block hover:scale-[1.02] transition-transform duration-200">
                        <div class="text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" width="100" height="100">
                            <h1 class="text-xl font-bold text-gray-800">Axe Capital</h1>
                            <p class="text-sm text-gray-500 mt-1">Gestion financière</p>
                        </div>
                    </a>

                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                    <div class="space-y-1">

                        @auth
                        @if(Auth::user()->role === 'gestionnaire_compte')
                        <a href="{{route('dashboardCompte')}}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </a>
                        @endif
                        @endauth


                        @auth
                        @if(Auth::user()->role === 'gest-financement')
                        <a href="{{route('projet.dashboard')}}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </a>
                        @endif
                        @endauth

                        @auth
                        @if(Auth::user()->role === 'gestionnaire_credit')
                        <a href="{{route('credit.dashboard')}}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </a>
                        @endif
                        @endauth

                        @auth
                        @if(Auth::user()->role === 'gest-import')
                        <a href="{{route('dashboard.import')}}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </a>
                        @endif
                        @endauth
                        @auth
                        @if(Auth::user()->role === 'admin')
                        <a href="{{route('dashboard')}}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </a>
                        @endif
                        @endauth



                        <a href="{{route('create.account')}}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Creation de compte
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">3</span>
                        </a>

                        <a href="{{route('credit')}}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Crédit
                        </a>

                        <a href="{{route('financement')}}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            Financement
                            <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">Nouveau</span>
                        </a>

                        <a href="{{route('import.export')}}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            Import / Export
                        </a>
                    </div>

                    {{-- Séparateur --}}
                    <div class="border-t border-gray-200 my-4"></div>

                    {{-- Section secondaire --}}
                    <div class="space-y-1">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Support</h3>

                        <a href="#" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Aide & Support
                        </a>

                        <a href="{{ route('admin.users') }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Gestion des rôles
                        </a>

                    </div>
                </nav>

                {{-- Footer de la sidebar --}}
                @auth
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </aside>

        {{-- CONTENU PRINCIPAL --}}
        <div class="flex-1 flex flex-col content-area ml-0 md:ml-64">
            {{-- NAVBAR FIXE --}}
            <header class="navbar-fixed bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-200 px-4 md:px-6 py-4 flex justify-between items-center left-0 md:left-64 right-0">
                {{-- Burger menu (mobile) --}}
                <button class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" id="menuBtn">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Breadcrumb / Titre de page --}}
                <div class="flex-1 md:flex-none">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                        Bienvenue, {{ Auth::user()->name ?? 'Visiteur' }}
                    </h2>
                    <p class="text-sm text-gray-500 hidden md:block">Les petites tontine pour les grande Ambitions</p>
                </div>

                {{-- Actions utilisateur --}}
                <div class="flex items-center space-x-3">
                    {{-- Notifications --}}
                    @auth


                    {{-- Menu utilisateur --}}
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">{{ substr(Auth::user()->name, 0, 2) }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    {{-- Bouton de déconnexion --}}
                    <form method="POST" action="{{route('logout')}}" class="block">
                        @csrf
                        <button class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors text-sm font-medium w-full md:w-auto">
                            Déconnexion
                        </button>
                    </form>
                    @endauth

                    @guest
                    <div class="flex space-x-2">
                        <a href="{{route('login')}}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register.form') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm font-medium hidden md:block">
                            S'inscrire
                        </a>
                    </div>
                    @endguest
                </div>
            </header>

            {{-- ZONE DE CONTENU SCROLLABLE --}}
            <main class="flex-1 overflow-y-auto pt-20 pb-6">
                <div class="px-4 md:px-6 py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- SCRIPT pour gestion du menu mobile et interactions --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('menuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            // Toggle du menu mobile
            function toggleMobileMenu() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.classList.toggle('overflow-hidden');
            }

            // Event listeners
            menuBtn?.addEventListener('click', toggleMobileMenu);
            overlay?.addEventListener('click', toggleMobileMenu);

            // Fermeture automatique sur redimensionnement
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.classList.remove('overflow-hidden');
                }
            });

            // Gestion du scroll de la navbar
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar-fixed');

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scroll vers le bas - cacher la navbar
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scroll vers le haut - montrer la navbar
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            });
        });
    </script>
</body>

</html>