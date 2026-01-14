<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Créer un nouvel utilisateur
        </h2>
    </x-slot>

    @include('header')

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="name">Nom complet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           required autocomplete="email"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-300">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-300">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-300">
                </div>

                
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
