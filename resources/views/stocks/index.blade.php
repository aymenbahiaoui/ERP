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
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session('success') }}
    </div>
@endif
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categorie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock Initial
                                    @canany(['admin', 'dc', 'df'])
                                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="text-white bg-blue-500 hover:bg-blue-600 text-xs px-2 py-1 rounded">+</button>
                                    @endcanany
                                    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                        <div class="bg-white p-4 rounded-lg w-72 shadow-lg">
                                            <h2 class="text-sm font-bold mb-2">Upload Stock File</h2>
                                            <form action="{{ route('si.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="text-xs mb-3 w-full" required>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-500 text-xs">Cancel</button>
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inventaire
                                    @canany(['admin', 'dc', 'df'])
                                    <button onclick="document.getElementById('inventaireModal').classList.remove('hidden')" class="text-white bg-blue-500 hover:bg-blue-600 text-xs px-2 py-1 rounded">+</button>
                                    @endcanany
                                    <div id="inventaireModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                        <div class="bg-white p-4 rounded-lg w-72 shadow-lg">
                                            <h2 class="text-sm font-bold mb-2">Inventaire</h2>
                                            <form action="{{ route('inventaire.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="text-xs mb-3 w-full" required>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" onclick="document.getElementById('inventaireModal').classList.add('hidden')" class="text-gray-500 text-xs">Cancel</button>
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vente</th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Charge
                                    @canany(['admin', 'dc', 'df'])
                                    <button onclick="document.getElementById('chargeModal').classList.remove('hidden')" class="text-white bg-blue-500 hover:bg-blue-600 text-xs px-2 py-1 rounded">+</button>
                                    @endcanany
                                    <div id="chargeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                        <div class="bg-white p-4 rounded-lg w-72 shadow-lg">
                                            <h2 class="text-sm font-bold mb-2">Importer Charge</h2>
                                            <form action="{{ route('charge.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="text-xs mb-3 w-full" required>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" onclick="document.getElementById('chargeModal').classList.add('hidden')" class="text-gray-500 text-xs">Cancel</button>
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Décharge</th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Stock</th>
                        
                               
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Différence</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stocks as $stock)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stock->categorie }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stock->produit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500  ">{{ number_format($stock->si, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">{{ number_format($stock->inventaire, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($stock->ventre, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($stock->charge, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm  text-gray-500">{{ number_format($stock->decharge, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($stock->sf, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $stock->ecart < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    {{ number_format($stock->ecart, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">le stock est vide</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                
            </div>
        </div>
    </div>
</x-app-layout>
