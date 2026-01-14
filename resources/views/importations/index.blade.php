<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')

        <div class="container mx-auto p-4 md:p-6">
            
            <!-- Header Section with Filter and Actions -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                @canany(['admin', 'df'])
                <a href="{{ route('importations.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nouvelle Importation
                </a>
                @endcanany
                
                @if(request('sku_filter') && $cout_moyen)
                <div class="w-full md:w-auto text-lg font-semibold text-teal-700 whitespace-nowrap">
                    Coût Moyen Total : {{ number_format($cout_moyen, 2) }} DH
                </div>
                @endif
                
                <form method="GET" action="{{ route('importations.index') }}" class="w-full flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <div class="flex-grow w-full">
                        <input type="text" name="sku_filter" placeholder="Filtrer par SKU..." 
                               value="{{ request('sku_filter') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg">
                            Filtrer
                        </button>
                        @if(request('sku_filter'))
                            <a href="{{ route('importations.index') }}" class="w-full sm:w-auto text-center text-gray-600 hover:text-gray-800 whitespace-nowrap">
                                Effacer
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Main Content - Tables -->
            <div class="space-y-8">
                
                <!-- Cost Information Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="px-4 py-3 bg-gray-100 border-b">
                        <h3 class="text-lg font-medium text-gray-700">Informations de Coût</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">N° Facture</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date Facture</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coût FOB</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Coût Total</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coût Unitaire</th>
                                    @canany(['admin', 'df'])
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->sku?->nom ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->order_number }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">{{ $item->invoice_number }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">{{ $item->invoice_date }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->paid_quantity }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item->cost_fob, 2) }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">{{ number_format($item->cout_total, 2) }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item->cout_unit, 2 ?? 99) }}</td>
                                    @canany(['admin', 'df'])
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('importations.show',$item->id) }}" class="text-green-600 hover:text-green-900" title="Détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('importations.edit',$item->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('importations.destroy',$item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payment Information Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="px-4 py-3 bg-gray-100 border-b">
                        <h3 class="text-lg font-medium text-gray-700">Informations de Paiement</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FOB</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Taux Paiement</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date Arrivée</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Reste à Payer</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">Date Échéance</th>
                                    @canany(['admin', 'df'])
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->sku?->nom ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->order_number }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->cost_fob }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">{{ $item->taux }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->paiment }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">{{ $item->date_darivee}}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">{{$item->reste}}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">{{ $item->date_dechange }}</td>
                                    @canany(['admin', 'df'])
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('importations.show',$item->id) }}" class="text-green-600 hover:text-green-900" title="Détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('importations.edit',$item->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('importations.destroy',$item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>