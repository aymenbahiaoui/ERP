<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des chèques') }}
        </h2>
    </x-slot>

    @include('header')
    <div class="bg-gradient-to-br from-teal-50 to-blue-50 min-h-screen p-4">

        <div class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow-md">
            
            <div class="mb-6 p-4 bg-gray-50 rounded-lg print:hidden">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Filtrer les chèques</h3>
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4" method="GET">
                    <div>
                        <label for="vendeur" class="block text-sm font-medium text-gray-700">Vendeur</label>
                        <select id="vendeur" name="vendeur" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Tous les vendeurs</option>
                            @foreach($vendeurs as $v)
                                <option value="{{ $v->vendeur }}" {{ request('vendeur') == $v->vendeur ? 'selected' : '' }}>{{ $v->vendeur }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="etat" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select id="etat" name="etat"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Tous les statuts</option>
    @php
        $options = [ 'garante', 'payés', 'impayée', 'en caissement', 'en porte feuille', 'contre espèce' ];
    @endphp
    @foreach ($options as $option)
        <option value="{{ $option }}" {{ old('etat', request('etat')) === $option ? 'selected' : '' }}>
            {{ ucfirst($option) }}
        </option>
    @endforeach
</select>

                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Appliquer les filtres
                        </button>
                    </div>
                </form>
                
                @if(request()->hasAny(['vendeur', 'etat']))
                    <div class="mt-4">
                        <a href="{{ route('cheque.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Réinitialiser
                        </a>
                    </div>
                @endif
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Total des chèques</div>
                    <div class="text-2xl font-bold">{{ count($cheques) }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Montant total</div>
                    <div class="text-2xl font-bold">{{ number_format($totalMontant, 2) }} DH</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm">Chèques filtrés</div>
                    <div class="text-2xl font-bold">{{ count($cheques) }}</div>
                </div>
            </div>

            
            <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Imprimer la page
            </button>
            <div class="overflow-x-auto rounded-lg border border-gray-200 mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chèque #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Date d’échéance</th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Client</th> --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d’opération</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            @canany(['admin','df'])
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cheques as $cheque)
                        <tr class="{{ strtolower($cheque->etat) === 'payés' || strtolower($cheque->etat) === 'payes' ? 'bg-green-50' : 'bg-red-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $cheque->N_cheque ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 print:hidden">
                                {{ \Carbon\Carbon::parse($cheque->date1)->format('d/m/Y') }}
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 print:hidden">
                                {{ $cheque->client->client ?? '-' }}
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cheque->vendeur->vendeur ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ number_format($cheque->montant->cheque_details ?? 0, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 print:hidden">
                                {{ \Carbon\Carbon::parse($cheque->date2)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ strtolower($cheque->etat) === 'payés' || strtolower($cheque->etat) === 'payes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $cheque->etat ?? '---' }}
                                </span>
                            </td>
                            @canany(['admin', 'df'])
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium print:hidden">
                                <a href="{{ route('cheque.edit', $cheque->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</a>
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
