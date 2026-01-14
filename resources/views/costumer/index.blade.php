<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-teal-50 min-h-screen w-full">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @include('header')

        <div class="w-full min-h-[91vh] flex flex-col items-center justify-center space-y-6 p-4">
            @if(session('success'))
                <div class="text-green-600 font-semibold bg-green-100 p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="text-red-600 font-semibold bg-red-100 p-3 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div>
                <form action="{{ route('costumer.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    class="max-w-sm p-6 bg-white shadow-lg rounded-lg flex flex-col items-center space-y-4">
                    @csrf
                    <div class="w-full space-y-2">
                        <label class="w-full text-center cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg border border-gray-300">
                            <input type="file" name="file" class="hidden" accept=".csv,.xlsx,.xls">
                            📂 Choisir un fichier
                        </label>
                        <p id="fileName" class="text-sm text-gray-500 text-center"></p>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition">
                        📤 Soumettre
                    </button>
                </form>
            </div>

            
            <div class="w-full max-w-6xl p-4 bg-white rounded-lg shadow-lg overflow-x-auto">
                <h3 class="text-lg font-semibold mb-4">Données de vente</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Janvier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Février</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mars</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avril</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juillet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Août</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Septembre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Octobre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Novembre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Décembre</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($salesData as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product["produit"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product["janvier"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['février'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['mars'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['avril'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['mai'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['juin'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product["juillet"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product["août"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product["septembre"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product["octobre"] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['novembre'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['décembre'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <label for="chartType" class="font-medium">Type de graphique:</label>
                <select id="chartType" class="p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="bar">Barres</option>
                    <option value="line">Ligne</option>
                    <option value="pie">Camembert</option>
                    <option value="doughnut">Anneau</option>
                    <option value="radar">Radar</option>
                </select>
            </div>

            <div class="w-full max-w-4xl p-4 bg-white rounded-lg shadow-lg">
                <div class="aspect-w-16 aspect-h-9">
                    <canvas id="salesChart" class="min-h-screen"></canvas>
                </div>
            </div>
        </div>

        <script>
            const salesData = @json($salesData); 

let colors = [
  '#FF5733',
  '#33FF57',
  '#3357FF',
  '#FF33A8',
  '#A833FF',
  '#33FFF6',
  '#FF8C33',
  '#33FF8C',
  '#8C33FF',
  '#FF3380',
  '#3380FF',
  '#33A8FF' 
]
;

//
let datasets = salesData.map((product, index) => {
    
    const monthValues = [
        product.janvier, product.février, product.mars, product.avril,
        product.mai, product.juin, product.juillet, product.août,
        product.septembre, product.octobre, product.novembre, product.décembre
    ];
    
    
    const allMonthLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
    
    
    const filteredData = [];
    const filteredLabels = [];
    
    monthValues.forEach((value, i) => {
        if (value !== null && value !== undefined && value !== '') {
            filteredData.push(value);
            filteredLabels.push(allMonthLabels[i]);
        }
    });
    
    
    return {
        label: product.produit,
        data: filteredData,
        borderWidth: 2,
        backgroundColor: colors[index % colors.length],
        borderColor: colors[index % colors.length],
        fill: false,
        
        _filteredLabels: filteredLabels
    };
});


const allMonths = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
const activeMonths = new Set();

datasets.forEach(dataset => {
    dataset._filteredLabels.forEach(label => {
        activeMonths.add(label);
    });
});


const labels = allMonths.filter(month => activeMonths.has(month));


let chart = new Chart(document.getElementById("salesChart"), {
    type: "bar",
    data: { labels, datasets },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


document.getElementById('chartType').addEventListener('change', function() {
    chart.destroy();
    chart = new Chart(document.getElementById("salesChart"), {
        type: this.value,
        data: { labels, datasets },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});


document.querySelector('input[name="file"]').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Aucun fichier sélectionné';
    document.getElementById('fileName').textContent = fileName;
});
        </script>
    </div>
</x-app-layout>