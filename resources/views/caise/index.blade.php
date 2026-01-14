<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facture Summary') }}
        </h2>
    </x-slot>
    @include('header')
<style>
      @media print {
    .sidebar {
        display: none !important;
    }
   
}
</style>
    <div class="py-6 bg-gray-50">
        
        <form action="" method="GET">
           
            @foreach($fact->pluck('vendeur')->unique() as $vendeur)
            <h1 class="text-3xl text-center my-5 hidden print:block">
                {{ $vendeur }}</h1>
                @endforeach
        </form>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('edit'))
            <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                <p>{{ session('edit') }}</p>
            </div>
        @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
                <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 sidebar">
                    <form method="GET" action="{{ route('caise.index') }}" class="w-full sm:w-auto">
                        <div class="flex flex-col sm:flex-row gap-2 w-full">
                            <!-- Dans votre vue (Blade) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 ">
    <!-- Filtre par vendeur -->
    <div class="relative flex-grow">
        <label for="vendeur" class="block text-sm font-medium text-gray-700 mb-1">Vendeur</label>
        <select name="vendeur" id="vendeur" class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Tous les vendeurs</option>
            @foreach($fact->pluck('vendeur')->unique() as $vendeur)
                <option value="{{ $vendeur }}" {{ request('vendeur') == $vendeur ? 'selected' : '' }}>{{ $vendeur }}</option>
            @endforeach
        </select>
    </div>

    <!-- Filtre par date début -->
    <div class="relative flex-grow">
        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
        <input type="date" name="date_debut" id="date_debut" 
               value="{{ request('date_debut') }}" 
               class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <!-- Filtre par date fin -->
    <div class="relative flex-grow">
        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
        <input type="date" name="date_fin" id="date_fin" 
               value="{{ request('date_fin') }}" 
               class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>
<div class="mb-6 flex items-end">
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        Filtrer
    </button>
    @if(request()->hasAny(['vendeur', 'date_debut', 'date_fin']))
        <a href="{{ route('caise.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
            Réinitialiser
        </a>
    @endif
</div>

<!-- Bouton de filtre -->
                            
                          
                        </div>
                    </form>

                    <div>
                        <button id="toggleTable" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Payant BL
                        </button>
                        <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Imprimer la page
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 p-4 bg-gray-50 border-b print:grid-cols-3">
                    
                      <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Total BL</h3>
                        <p class="mt-1 text-2xl font-semibold text-green-600">{{ number_format($fact->sum('total_valeur'), 2) }} DH</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Total espece</h3>
                        <p class="mt-1 text-2xl font-semibold text-indigo-600">
                            {{ number_format($fact->sum('espece_details'), 2) }} DH
                        </p>
                    </div>
                    
                     <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Total Chèque</h3>
                        <p class="mt-1 text-2xl font-semibold text-yellow-600">
                            {{ number_format($fact->sum('cheque_details'), 2) }} DH
                        </p>
                    </div>
                    
                     <form action="" method="GET" class="hidden print:block">
            @foreach($fact->pluck('vendeur')->unique() as $vendeur)
            <h1 class="text-xl text-center my-5 ">
                {{ $vendeur }}</h1>
                @endforeach
        </form>
                       
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Total instances</h3>
                        <p class="mt-1 text-2xl font-semibold text-red-600">{{ number_format($fact->sum('montant_reste'), 2) }} DH</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Reste à versé</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($fact->sum('espece_details') - $totalVersement) }} DH</p>
                    </div>
                
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 print:hidden">
                        <h3 class="text-sm font-medium text-gray-500">Versement</h3>
                        <p class="mt-1 text-2xl font-semibold text-blue-600">{{ number_format($totalVersement, 2) }} DH</p>
                    </div>
                
                   
                  
                
                 
                
                    
                    
                
                    
                   
                </div>
                

                <div class="overflow-x-auto" id="unpaidTableSection">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                {{-- <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendeur</th> --}}
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BL</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant (DH)</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode de paiement</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ُEspece</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cheque</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instances</th>
                                @canany(['admin', 'df'])
                                <th scope="col" class="px-6 py-3 print:p-1 text-right text-xs font-medium text-gray-500 uppercase tracking-wider  print:hidden">Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($fact as $facture)
                                @if ($facture->total_valeur != 0 && $facture->validation == "0")
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($facture->date)->format('m/d/Y') }}
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $facture->vendeur }}</div>
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $facture->numero_facture }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium {{ $facture->total_valeur > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($facture->total_valeur, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            @php
                                                $modes = explode(',', $facture->mode_de_paiement);
                                                $modeClasses = [
                                                    'cheque' => 'bg-blue-100 text-blue-800',
                                                    'espece' => 'bg-green-100 text-green-800',
                                                    'instance' => 'bg-purple-100 text-purple-800',
                                                    'virement' => 'bg-yellow-100 text-yellow-800'
                                                ];
                                            @endphp
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($modes as $mode)
                                                    @php $mode = trim(strtolower($mode)); @endphp
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $modeClasses[$mode] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($mode) }}
                                                        @if($mode === 'cheque' && !empty($facture->cheque_number))
                                                            ({{ $facture->cheque_number }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-green-600">
                                            {{ number_format($facture->montant_payant, 2) }} DH
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-blue-600">
                                            {{ number_format($facture->espece_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-yellow-600">
                                            {{ number_format($facture->cheque_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-red-600">
                                            {{ number_format($facture->montant_reste, 2) }} DH
                                        </td>
                                        @canany(['admin', 'df'])
                                            
                                       
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-right text-sm font-medium  print:hidden">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('caise.edit', $facture->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors"
                                                   title="Edit Facture">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                
                                            </div>
                                        </td>
                                        @endcanany
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="overflow-x-auto hidden" id="paidTableSection">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                {{-- <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendeur</th> --}}
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facture</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant (DH)</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode de paiement</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ُEspece</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cheque</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instances</th>
                                @canany(['admin', 'df'])
                                <th scope="col" class="px-6 py-3 print:p-1 text-right text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($fact as $facture)
                                @if ($facture->total_valeur != 0 && $facture->validation == "1")
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($facture->date)->format('m/d/Y') }}
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $facture->vendeur }}</div>
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $facture->numero_facture }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium {{ $facture->total_valeur > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($facture->total_valeur, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            @php
                                                $modes = explode(',', $facture->mode_de_paiement);
                                                $modeClasses = [
                                                    'cheque' => 'bg-blue-100 text-blue-800',
                                                    'espece' => 'bg-green-100 text-green-800',
                                                    'instance' => 'bg-purple-100 text-purple-800',
                                                    'virement' => 'bg-yellow-100 text-yellow-800'
                                                ];
                                            @endphp
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($modes as $mode)
                                                    @php $mode = trim(strtolower($mode)); @endphp
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $modeClasses[$mode] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($mode) }}
                                                        @if($mode === 'cheque' && !empty($facture->cheque_number))
                                                            ({{ $facture->cheque_number }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-green-600">
                                            {{ number_format($facture->montant_payant, 2) }} DH
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-blue-600">
                                            {{ number_format($facture->espece_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-yellow-600">
                                            {{ number_format($facture->cheque_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-red-600">
                                            {{ number_format($facture->montant_reste, 2) }} DH
                                        </td>
                                        @canany(['admin', 'df'])
                                            
                                        
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-right text-sm font-medium  print:hidden" >
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('caise.edit', $facture->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors"
                                                   title="Edit Facture">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <a href="#" 
                                                   class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors"
                                                   title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                        @endcanany
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        // Print functionality
        document.getElementById('printPageButton').addEventListener('click', function() {
            window.print();
        });
    
        // Optional: Improve print styling by adding a print stylesheet or media query
        const style = document.createElement('style');
        style.innerHTML = `
              <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                {{-- <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendeur</th> --}}
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facture</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant (DH)</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode de paiement</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ُEspece</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cheque</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instances</th>
                                <th scope="col" class="px-6 py-3 print:p-1 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($fact as $facture)
                                @if ($facture->total_valeur != 0 && $facture->montant_payant !== $facture->total_valeur)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($facture->date)->format('m/d/Y') }}
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $facture->vendeur }}</div>
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $facture->numero_facture }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium {{ $facture->total_valeur > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($facture->total_valeur, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap">
                                            @php
                                                $modes = explode(',', $facture->mode_de_paiement);
                                                $modeClasses = [
                                                    'cheque' => 'bg-blue-100 text-blue-800',
                                                    'espece' => 'bg-green-100 text-green-800',
                                                    'instance' => 'bg-purple-100 text-purple-800',
                                                    'virement' => 'bg-yellow-100 text-yellow-800'
                                                ];
                                            @endphp
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($modes as $mode)
                                                    @php $mode = trim(strtolower($mode)); @endphp
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $modeClasses[$mode] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($mode) }}
                                                        @if($mode === 'cheque' && !empty($facture->cheque_number))
                                                            ({{ $facture->cheque_number }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        {{-- <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-green-600">
                                            {{ number_format($facture->montant_payant, 2) }} DH
                                        </td> --}}
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-blue-600">
                                            {{ number_format($facture->espece_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-yellow-600">
                                            {{ number_format($facture->cheque_details, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-sm font-medium text-red-600">
                                            {{ number_format($facture->montant_reste, 2) }} DH
                                        </td>
                                        <td class="px-6 py-4 print:p-1 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('caise.edit', $facture->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors"
                                                   title="Edit Facture">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <a href="#" 
                                                   class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors"
                                                   title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
        `;
        // document.head.appendChild(style);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleTable');
            const unpaidSection = document.getElementById('unpaidTableSection');
            const paidSection = document.getElementById('paidTableSection');
            
            let showingPaid = false;
            
            toggleButton.addEventListener('click', function() {
                showingPaid = !showingPaid;
                
                if (showingPaid) {
                    unpaidSection.classList.add('hidden');
                    paidSection.classList.remove('hidden');
                    toggleButton.textContent = 'BL Payant';
                    toggleButton.classList.remove('bg-indigo-100', 'text-indigo-700');
                    toggleButton.classList.add('bg-green-100', 'text-green-700');
                } else {
                    paidSection.classList.add('hidden');
                    unpaidSection.classList.remove('hidden');
                    toggleButton.textContent = 'BL non payant';
                    toggleButton.classList.remove('bg-green-100', 'text-green-700');
                    toggleButton.classList.add('bg-indigo-100', 'text-indigo-700');
                }
            });
        });
    </script>
</x-app-layout>