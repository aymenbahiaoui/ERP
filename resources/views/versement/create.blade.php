<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-wallet mr-1"></i> Ajouter Versement
        </h2>
    </x-slot>
    @include('header')
    <div class="py-8 px-4 max-w-xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @canany(["admin",'df'])
        <form method="POST" action="{{ route('verement.store') }}" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="vendeur" class="block text-gray-700">Vendeur:</label>
                <select name="vendeur" id="vendeur" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="">-- Sélectionner un vendeur --</option>
                    @foreach($vendeurs as $vendeur)
                        <option value="{{ $vendeur->vendeur }}">{{ $vendeur->vendeur }}</option>
                    @endforeach
                </select>
                
            </div>

            <div class="mb-4">
                <label for="versement" class="block text-gray-700">Montant du versement:</label>
                <input type="number" name="versement" id="versement" 
                       class="w-full border rounded px-3 py-2 mt-1" 
                       required min="0" step="0.01">
            </div>

            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">
                Enregistrer
            </button>
        </form>
        @endcanany

       @canany(['comm'])
       <form action="{{ route('verement.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto p-4 bg-white shadow-md rounded-xl space-y-4">
        @csrf
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <input type="file" name="image" id="image" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    
        <div>
            <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
            <input type="number" name="montant" id="montant" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            Submit
        </button>
    </form>
    
       @endcanany
        
    </div>
</x-app-layout>
