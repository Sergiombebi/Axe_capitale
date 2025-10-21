@extends('layouts.home')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-sm text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">🔒 Accès protégé</h1>

        @if(session('error'))
            <p class="text-red-500 text-sm mb-4">{{ session('error') }}</p>
        @endif

        <form action="{{ route('admin.users') }}" method="POST">
            @csrf
            <input type="password" name="password" placeholder="Mot de passe" 
                   class="w-full p-3 border rounded-lg mb-4 focus:ring focus:ring-blue-200 focus:outline-none" required>
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Accéder
            </button>
        </form>
    </div>

</div>
@endsection
