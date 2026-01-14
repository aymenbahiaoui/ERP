<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>

    <div class="text-gray-900 bg-teal-50 min-h-screen">
       @include('header')
{{-- @canany(['admin', 'dg']) --}}
    
<div class="p-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
    {{-- @canany(['admin','dg','df','sup']) --}}
    <div class="bg-white  rounded-2xl shadow-md p-4">
        <h3 class="text-lg font-bold mb-4 text-teal-700">Top 5 Clients</h3>
        <canvas id="clientsChart" height="300"></canvas>
    </div>
    {{-- @endcanany --}}

   
    <div class="bg-white rounded-2xl shadow-md p-4">
        <h3 class="text-lg font-bold mb-4 text-teal-700">Top 5 Articles</h3>
        <canvas id="articlesChart" height="300"></canvas>
    </div>

    @canany(['admin','dg','df','sup'])
    <div class="bg-white rounded-2xl shadow-md p-4">
        <h3 class="text-lg font-bold mb-4 text-teal-700">Top 5 Vendeurs</h3>
        <canvas id="vendeursChart" height="300"></canvas>
    </div>
    @endcanany

   
    <div class="bg-white rounded-2xl shadow-md p-4">
        <h3 class="text-lg font-bold mb-4 text-teal-700">Top 5 Catégories</h3>
        <canvas id="categoriesChart" height="300"></canvas>
    </div>
</div>
{{-- @endcanany --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                new Chart(document.getElementById('clientsChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($topClients->pluck('client')),
                        datasets: [{
                            label: 'Total Value',
                            data: @json($topClients->pluck('total')),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    moyenne: {
                                        type: 'line',
                                        yMin: {{ $topClients->pluck('total')->avg() }},
                                        yMax: {{ $topClients->pluck('total')->avg() }},
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Moyenne',
                                            enabled: true,
                                            position: 'start'
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                
                new Chart(document.getElementById('articlesChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($topArticles->pluck('designation')),
                        datasets: [{
                            label: 'Total Quantity',
                            data: @json($topArticles->pluck('total_quantity')),
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    moyenne: {
                                        type: 'line',
                                        yMin: {{ $topArticles->pluck('total_quantity')->avg() }},
                                        yMax: {{ $topArticles->pluck('total_quantity')->avg() }},
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Moyenne',
                                            enabled: true,
                                            position: 'start'
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                
                new Chart(document.getElementById('vendeursChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($topVendeur->pluck('vendeur')),
                        datasets: [{
                            label: 'Total Quantity',
                            data: @json($topVendeur->pluck('total_quantity')),
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    moyenne: {
                                        type: 'line',
                                        yMin: {{ $topVendeur->pluck('total_quantity')->avg() }},
                                        yMax: {{ $topVendeur->pluck('total_quantity')->avg() }},
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Moyenne',
                                            enabled: true,
                                            position: 'start'
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                
                new Chart(document.getElementById('categoriesChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($topCategorie->pluck('categorie')),
                        datasets: [{
                            label: 'Total Quantity',
                            data: @json($topCategorie->pluck('total_quantity')),
                            backgroundColor: 'rgba(153, 102, 255, 0.5)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    moyenne: {
                                        type: 'line',
                                        yMin: {{ $topCategorie->pluck('total_quantity')->avg() }},
                                        yMax: {{ $topCategorie->pluck('total_quantity')->avg() }},
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Moyenne',
                                            enabled: true,
                                            position: 'start'
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
