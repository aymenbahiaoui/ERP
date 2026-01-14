<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Continuer Chèque E-Commerce') }}
        </h2>
    </x-slot>
    @include('header')
   
    <div class="py-8">
        @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
                @if ($loop->index < 5)
                    <li>{{ $error }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('cdn') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Montant Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="montantbl" class="block text-sm font-medium text-gray-700 mb-1">Montant INSTANCE (MAD)</label>
                            <input type="number" step="0.01" name="montantbl" id="montantbl" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ old('montantbl', $cheque->instance) }}" required>
                        </div>
                        <div>
                            <label for="montantpayant" class="block text-sm font-medium text-gray-700 mb-1">Montant Payant (MAD)</label>
                            <input type="number" step="0.01" name="montantpayant" id="montantpayant" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                   value="" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label for="datebl" class="block text-sm font-medium text-gray-700 mb-1">Date BL</label>
                            <input type="date" name="datebl" id="datebl"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                        <div>
                            <label for="datepaiment" class="block text-sm font-medium text-gray-700 mb-1">Date Paiement</label>
                            <input type="date" name="datepaiment" id="datepaiment"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                        <div>
                            <label for="datedecheance" class="block text-sm font-medium text-gray-700 mb-1">Date Échéance</label>
                            <input type="date" name="datedecheance" id="datedecheance"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Factures Field -->
                    @php
    $cleanExistingFactures = collect($existingFactures)->map(fn($f) => trim($f))->toArray();
@endphp

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Factures Disponibles</label>
    <div class="border rounded-md p-2 max-h-60 overflow-y-auto">
        @forelse($factures as $facture)
            @php
                $isAssociated = in_array(trim($facture->numero_facture), $cleanExistingFactures);
            @endphp
            @if($isAssociated)
                <div class="flex items-center py-2 px-1 hover:bg-gray-50 rounded">
                    <input type="checkbox" name="factures[]" value="{{ $facture->numero_facture }}" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        checked onclick="return false;">
                    <div class="ml-3">
                        <span class="text-sm font-medium text-gray-900">{{ $facture->numero_facture }}</span>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-sm text-gray-500">Aucune facture disponible</p>
        @endforelse
    </div>
</div>

                    
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image du chèque</label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100" 
                               required>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cheques.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>