@extends('layouts.home')

@section('content')
<div class="container mx-auto py-10 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👥 Gestion des utilisateurs</h1>
        <a href="{{ route('admin.logoutAccess') }}" 
           class="text-sm text-red-600 hover:underline">
            Déconnexion
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-2xl shadow">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Rôle actuel</th>
                    <th class="px-6 py-3 text-center">Modifier le rôle</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $user->id }}</td>
                    <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-6 py-3">{{ $user->email }}</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs 
                            {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" 
                              method="POST" class="inline-flex gap-2 items-center">
                            @csrf
                            <select name="role" class="border rounded-lg p-1 text-sm focus:ring focus:ring-blue-200">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>user</option>
                                <option value="gest-import" {{ $user->role === 'gest-import' ? 'selected' : '' }}>gest-import</option>
                                <option value="gestionnaire_compte" {{ $user->role === 'gestionnaire_compte' ? 'selected' : '' }}>gestionnaire_compte</option>
                                <option value="gestionnaire_credit" {{ $user->role === 'gestionnaire_credit' ? 'selected' : '' }}>gestionnaire_credit</option>
                                <option value="gest-financement" {{ $user->role === 'gest-financement' ? 'selected' : '' }}>gest-financement</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                            </select>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                OK
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
