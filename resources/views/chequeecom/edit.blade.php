<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Chèque E-Commerce') }}
        </h2>
    </x-slot>
@include('header')
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('cheques.update') }}" enctype="multipart/form-data">
                    @csrf

                    
                    <div class="mb-6">
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Montant (MAD)</label>
                        <input type="number" step="0.01" name="montant" id="montant" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               required>
                        <p id="selected-total" class="text-sm text-gray-500 mt-1 hidden">
                            Total sélectionné: <span class="font-medium">0.00</span> MAD
                        </p>
                    </div>

                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Factures Disponibles</label>
                        <div class="border rounded-md p-2 max-h-60 overflow-y-auto">
                            @foreach($factures as $facture)
                            @php
                                $alreadyUsed = \App\Models\chequecomModel::where('bl', 'LIKE', "%$facture->numero_facture%")->exists();
                            @endphp
                        
                            @if(!$alreadyUsed)
                                <div class="flex items-center py-2 px-1 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="factures[]" value="{{ $facture->numero_facture }}" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded facture-checkbox"
                                           data-value="{{ $facture->total_valeur }}">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">{{ $facture->numero_facture }}</span>
                                        <span class="text-xs text-gray-500 ml-2">{{ number_format($facture->total_valeur, 2) }} MAD</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Total disponible: {{ number_format($factures->sum('total_valeur'), 2) }} MAD
                        </p>
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

                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cheques.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.facture-checkbox');
            const montantInput = document.getElementById('montant');
            const selectedTotalElement = document.getElementById('selected-total');
            const selectedTotalAmount = selectedTotalElement.querySelector('span');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTotal);
            });
            
            function updateSelectedTotal() {
                let total = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.dataset.value);
                    }
                });
                
                montantInput.value = total.toFixed(2);
                
                if (total > 0) {
                    selectedTotalAmount.textContent = total.toFixed(2);
                    selectedTotalElement.classList.remove('hidden');
                } else {
                    selectedTotalElement.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout>