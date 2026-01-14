<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Chèques E-Commerce') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')

        <div class="p-4">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('delete'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p>{{ session('delete') }}</p>
                </div>
            @endif
            
            
            <form method="GET" action="{{ route('cheques.index') }}" class="flex items-center gap-4 mb-6 bg-white p-4 rounded shadow">
                <div>
                    <label for="vendeur" class="font-semibold mr-2">Filtrer par vendeur:</label>
                    <select name="vendeur" id="vendeur" class="border px-2 py-1 rounded">
                        <option value="">-- Tous --</option>
                        @foreach ($vendeurs as $vendeur)
                            <option value="{{ $vendeur }}" {{ request('vendeur') == $vendeur ? 'selected' : '' }}>
                                {{ $vendeur }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                        Filtrer
                    </button>
                </div>

                <div>
                    <a href="{{ route('cheques.index') }}" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">
                        Réinitialiser
                    </a>
                </div>

                <div class="ml-auto font-bold text-lg text-teal-700">
                    Total: {{ number_format($totalCheques, 2) }} MAD
                </div>
            </form>

            
            <div class="mb-4 text-center">
                <button id="toggleChequesBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                    Afficher Chèques Validés
                </button>
            </div>

            
            <div id="pendingChequesTable" class="bg-white p-4 rounded shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Chèques en Attente de Validation</h2>
                    @canany(["comm"])
                    <a href="{{ route('cheques.create') }}"
                       class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                        + Nouveau chèque
                    </a>
                    @endcanany
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-left">
                                <th class="py-2 px-4 border">Date BL</th>
                                <th class="py-2 px-4 border">Image</th>
                                <th class="py-2 px-4 border">Montant BL</th>
                                <th class="py-2 px-4 border">Montant Payant</th>
                                <th class="py-2 px-4 border">Instance</th>
                                @canany(['admin', 'df'])
                                <th class="py-2 px-4 border">Vendeur</th>
                                @endcanany
                                <th class="py-2 px-4 border">BL</th>
                                <th class="py-2 px-4 border">Date Paiement</th>
                                <th class="py-2 px-4 border">Date Échéance</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cheques->where('validation', 0) as $cheque)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">{{ $cheque->datebl }}</td>
                                <td class="py-2 px-4">
                                    @if($cheque->image)
                                        <img src="{{ asset('storage/' . $cheque->image) }}" alt="Chèque" class="h-12 cursor-pointer" 
                                             onclick="window.open('{{ asset('storage/' . $cheque->image) }}', '_blank')">
                                    @else
                                        <span class="text-sm text-gray-400">Aucune image</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">{{ number_format($cheque->montantbl, 2) }} MAD</td>
                                <td class="py-2 px-4">{{ number_format($cheque->montantpayant, 2) }} MAD</td>
                                <td class="py-2 px-4">{{ $cheque->instance }}</td>
                               @canany(['admin', 'df'])
                               <td class="py-2 px-4">{{ $cheque->vendeur }}</td>
                               @endcanany
                                <td class="py-2 px-4">
                                    @php
                                        $factures = explode(',', $cheque->bl);
                                        $numeros = [];
                                        foreach($factures as $facture) {
                                            $parts = explode('/', trim($facture));
                                            if (isset($parts[1])) {
                                                $numeros[] = $parts[1];
                                            }
                                        }
                                    @endphp
                                    {{ implode(', ', $numeros) }}
                                </td>
                                <td class="py-2 px-4">{{ $cheque->datepaiment }}</td>
                                <td class="py-2 px-4">{{ $cheque->datedecheance }}</td>
                                <td class="py-2 px-4">
                                    @canany(['admin', 'df'])
    <form action="{{ route('val', $cheque->id) }}" method="POST" class="inline">
        @csrf
        @method('PUT')
        
        
        <input type="radio" name="validation" value="1" {{ old('validation', $cheque->validation) == 1 ? 'checked' : '' }}> valider
        <input type="radio" name="validation" value="0" {{ old('validation', $cheque->validation) == 0 ? 'checked' : '' }}> en attendre

        <button type="submit" class="text-blue-500 hover:text-blue-700 mr-2">
            Valider
        </button>
    </form>
@endcanany

                                    
                                    <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chèque?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="py-4 px-4 text-center text-gray-500">Aucun chèque en attente trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div id="validatedChequesTable" class="bg-white p-4 rounded shadow mb-6 hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Chèques Validés</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-left">
                                <th class="py-2 px-4 border">Date BL</th>
                                <th class="py-2 px-4 border">Image</th>
                                <th class="py-2 px-4 border">Montant BL</th>
                                <th class="py-2 px-4 border">Montant Payant</th>
                                <th class="py-2 px-4 border">Instance</th>
                                <th class="py-2 px-4 border">Vendeur</th>
                                <th class="py-2 px-4 border">BL</th>
                                <th class="py-2 px-4 border">Date Paiement</th>
                                <th class="py-2 px-4 border">Date Échéance</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cheques->where('validation', 1) as $cheque)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">{{ $cheque->datebl }}</td>
                                <td class="py-2 px-4">
                                    @if($cheque->image)
                                        <img src="{{ asset('storage/' . $cheque->image) }}" alt="Chèque" class="h-12 cursor-pointer" 
                                             onclick="window.open('{{ asset('storage/' . $cheque->image) }}', '_blank')">
                                    @else
                                        <span class="text-sm text-gray-400">Aucune image</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">{{ number_format($cheque->montantbl, 2) }} MAD</td>
                                <td class="py-2 px-4">{{ number_format($cheque->montantpayant, 2) }} MAD</td>
                                <td class="py-2 px-4">{{ $cheque->instance }}</td>
                                <td class="py-2 px-4">{{ $cheque->vendeur }}</td>
                                <td class="py-2 px-4">
                                    @php
                                        $factures = explode(',', $cheque->bl);
                                        $numeros = [];
                                        foreach($factures as $facture) {
                                            $parts = explode('/', trim($facture));
                                            if (isset($parts[1])) {
                                                $numeros[] = $parts[1];
                                            }
                                        }
                                    @endphp
                                    {{ implode(', ', $numeros) }}
                                </td>
                                <td class="py-2 px-4">{{ $cheque->datepaiment }}</td>
                                <td class="py-2 px-4">{{ $cheque->datedecheance }}</td>
                                <td class="py-2 px-4">
                                    @canany(['admin', 'df'])
    <form action="{{ route('val', $cheque->id) }}" method="POST" class="inline">
        @csrf
        @method('PUT')
        
        
        <input type="radio" name="validation" value="1" {{ old('validation', $cheque->validation) == 1 ? 'checked' : '' }}> valider
        <input type="radio" name="validation" value="0" {{ old('validation', $cheque->validation) == 0 ? 'checked' : '' }} > en attendre

        <button type="submit" class="text-blue-500 hover:text-blue-700 mr-2">
            Valider
        </button>
    </form>
@endcanany

                                    
                                    <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chèque?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="py-4 px-4 text-center text-gray-500">Aucun chèque validé trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pendingChequesTable = document.getElementById('pendingChequesTable');
            const validatedChequesTable = document.getElementById('validatedChequesTable');
            const toggleChequesBtn = document.getElementById('toggleChequesBtn');

            toggleChequesBtn.addEventListener('click', function() {
                if (validatedChequesTable.classList.contains('hidden')) {
                    // Show validated cheques, hide pending
                    validatedChequesTable.classList.remove('hidden');
                    pendingChequesTable.classList.add('hidden');
                    toggleChequesBtn.textContent = 'Afficher Chèques en Attente';
                    toggleChequesBtn.classList.remove('bg-blue-500');
                    toggleChequesBtn.classList.add('bg-gray-500');
                } else {
                    // Show pending cheques, hide validated
                    validatedChequesTable.classList.add('hidden');
                    pendingChequesTable.classList.remove('hidden');
                    toggleChequesBtn.textContent = 'Afficher Chèques Validés';
                    toggleChequesBtn.classList.remove('bg-gray-500');
                    toggleChequesBtn.classList.add('bg-blue-500');
                }
            });
        });
    </script>
</x-app-layout>