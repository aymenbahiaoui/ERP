<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        #invoiceSearch {
            transition: all 0.3s ease;
            width: 250px;
        }
        
        #invoiceSearch:focus {
            width: 300px;
        }
        
        .no-results td {
            padding: 1rem;
            font-style: italic;
        }
      

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
    
            
    <div class="text-gray-900 bg-teal-50 min-h-screen w-p">
        @include('header')
        
        <div class="p-6">
            
           @canany(['admin','dc'])
           <div class="bg-white p-6 rounded-lg shadow mb-6 sidebar">
            <h3 class="text-lg font-semibold mb-4">Importer des données</h3>
            <form action="{{ route('ca.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Fichier Excel</label>
                    <input type="file" name="file" id="file" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Importer
                </button>
            </form>
        </div>
           @endcanany

            
          
<div class="bg-white p-6 rounded-lg shadow mb-6 sidebar">
    <h3 class="text-lg font-semibold mb-4">Filtrer les données</h3>
    <form action="{{ route('ca.index') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                <input type="date" name="from_date" id="from_date" 
                       value="{{ request('from_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" name="to_date" id="to_date" 
                       value="{{ request('to_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="{{Auth::user()->role == "comm" ?"hidden" : ""}}">
                <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                <select name="ville" id="ville" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les villes</option>
                    @isset($villes)
                        @foreach($villes as $ville)
                            <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>{{ $ville }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div>
                <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client" id="client" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les clients</option>
                    @isset($clientsByVille)
                        @if(request('ville'))
                            @foreach($clientsByVille[request('ville')] ?? [] as $clientItem)
                                <option value="{{ $clientItem->client }}" {{ request('client') == $clientItem->client ? 'selected' : '' }}>
                                    {{ $clientItem->client }}
                                </option>
                            @endforeach
                        @endif
                    @endisset
                </select>
            </div>
            <div>
                <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                <select name="categorie" id="categorie" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les catégories</option>
                    @isset($categories)
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie }}" {{ request('categorie') == $categorie ? 'selected' : '' }}>{{ $categorie }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="{{Auth::user()->role == "comm" ?"hidden" : ""}}">
                <label for="vendeur" class="block text-sm font-medium text-gray-700">Vendeur</label>
                <select name="vendeur" id="vendeur" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les vendeurs</option>
                    @isset($vendeurs)
                        @foreach($vendeurs as $vendeur)
                            <option value="{{ $vendeur }}" {{ request('vendeur') == $vendeur ? 'selected' : '' }}>{{ $vendeur }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Appliquer le filtre
        </button>
        @if(request()->has('from_date') || request()->has('to_date') || request()->has('ville') || request()->has('client') || request()->has('categorie'))
            <a href="{{ route('ca.index') }}" 
               class="ml-2 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Réinitialiser
            </a>
        @endif
    </form>
</div>

            
            @isset($data)
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Résumé</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Enregistrements</p>
                            <p class="text-2xl font-bold">{{ count($data) }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Valeur Facturée</p>
                            <p class="text-2xl font-bold">{{ number_format($data->sum('valeur_fact'), 2) }} DH</p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 gap-6 mb-6 ">
                <div class="bg-white p-6 rounded-lg shadow">
                    <select id="chartType" 
                    class="border border-gray-300 sidebar rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="bar">Barres</option>
                <option value="pie">Camembert</option>
                <option value="line">Lignes</option>
                <option value="doughnut">Anneau</option>
            </select>
                    <h3 class="text-lg font-semibold mb-4">Valeur Facturée par Catégorie</h3>
                    <div class="h-80">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="mt-6 bg-white p-6 rounded-lg shadow overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Données importées</h3>
                    <div class="bg-gray-100 px-4 py-2 rounded-lg">
                        <span class="font-medium">Total: {{ number_format($data->sum('valeur_fact'), 2) }} DH</span>
                    </div>
                </div>
                <div class="relative sidebar">
                    <input type="text" id="invoiceSearch" placeholder="Rechercher par N° BL..." 
                           class="border border-gray-300 rounded-md shadow-sm py-2 px-3 pl-10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"> 
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
        
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendeur</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° BL</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valeur Fact (DH)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                            <tr class=" hover:bg-gray-50">
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->Date }}</td>
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->client }}</td>
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->vendeur }}</td>
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->ville }}</td>
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->categorie }}</td>
                                <td class="px-1 py-4 whitespace-nowrap">{{ $item->numero_facture ?? "walo" }}</td>
                                <td class="px-1 py-4 whitespace-nowrap text-right">{{ number_format($item->valeur_fact, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                
            </div>

            
            <script>
                 document.addEventListener('DOMContentLoaded', function() {
        const invoiceSearch = document.getElementById('invoiceSearch');
        const tableRows = document.querySelectorAll('tbody tr');
        const totalFooter = document.querySelector('tfoot tr td:last-child');
        
        invoiceSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let total = 0;
            let visibleRows = 0;
            
            tableRows.forEach(row => {
                const invoiceCell = row.querySelector('td:nth-child(6)'); 
                const valueCell = row.querySelector('td:nth-child(7)');
                const invoiceText = invoiceCell.textContent.toLowerCase();
                
                if (invoiceText.includes(searchTerm)) {
                    row.style.display = '';
                    visibleRows++;
               
                    const valueText = valueCell.textContent.replace(/[^\d.,]/g, '').replace(',', '');
                    total += parseFloat(valueText) || 0;
                } else {
                    row.style.display = 'none';
                }
            });
            
           
            if (totalFooter) {
                totalFooter.textContent = total.toLocaleString('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + ' DH';
            }
            
          
            if (visibleRows === 0) {
                const tbody = document.querySelector('tbody');
                if (!tbody.querySelector('.no-results')) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results text-center';
                    noResultsRow.innerHTML = '<td colspan="7" class="py-4 text-gray-500">Aucun résultat trouvé</td>';
                    tbody.appendChild(noResultsRow);
                }
            } else {
                const noResultsRow = document.querySelector('.no-results');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
            }
        });
    });
                document.addEventListener('DOMContentLoaded', function() {
                    const categoryData = JSON.parse(`{!! json_encode(
                        $data->groupBy("categorie")->map(function($items) {
                            return $items->sum("valeur_fact");
                        })
                    ) !!}`);
                    
                    const categories = Object.keys(categoryData);
                    const values = Object.values(categoryData);
                    
                    const backgroundColors = categories.map((_, index) => {
                        const hue = (index * 360 / categories.length) % 360;
                        return `hsla(${hue}, 70%, 50%, 0.7)`;
                    });
                    
                    const ctx = document.getElementById('categoryChart').getContext('2d');
                    
                    let chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: categories,
                            datasets: [{
                                label: 'Valeur Facturée (DH)',
                                data: values,
                                backgroundColor: backgroundColors,
                                borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return value.toLocaleString() + ' DH';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y.toLocaleString() + ' DH';
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                    
                    document.getElementById('chartType').addEventListener('change', function() {

                        chart.destroy();
                        

                        chart = new Chart(ctx, {
                            type: this.value,
                            data: {
                                labels: categories,
                                datasets: [{
                                    label: 'Valeur Facturée (DH)',
                                    data: values,
                                    backgroundColor: backgroundColors,
                                    borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                label += context.raw.toLocaleString() + ' DH';
                                                return label;
                                            }
                                        }
                                    }
                                },
                                scales: this.value === 'pie' || this.value === 'doughnut' ? {} : {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString() + ' DH';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                });
            </script>
            
            @endisset
        </div> 
    </div>
</x-app-layout>