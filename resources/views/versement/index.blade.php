<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')

        <div class="p-2 sm:p-4">
            @if(session('success'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm sm:text-base">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('update'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 text-sm sm:text-base">
                    <p>{{ session('update') }}</p>
                </div>
            @endif

            <form method="GET" action="{{ route('verement.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 mb-4 sm:mb-6 bg-white p-3 sm:p-4 rounded shadow">
                @canany(['admin', 'df'])
                    <div class="w-full sm:w-auto">
                        <label for="vendeur" class="font-semibold text-sm sm:text-base mr-2">Filtrer par vendeur:</label>
                        <select name="vendeur" id="vendeur" class="border px-2 py-1 rounded w-full sm:w-auto text-sm sm:text-base" onchange="this.form.submit()">
                            <option value="">-- Tous --</option>
                            @foreach ($versements->unique('vendeur') as $versement)
                                <option value="{{ $versement->vendeur }}" {{ request('vendeur') == $versement->vendeur ? 'selected' : '' }}>
                                    {{ $versement->vendeur }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-auto mt-2 sm:mt-0">
                        <a href="{{ route('verement.index') }}" class="block w-full sm:w-auto bg-red-500 text-white px-3 sm:px-4 py-1 rounded hover:bg-red-600 text-center text-sm sm:text-base">
                            Réinitialiser
                        </a>
                    </div>
                @endcanany

                <div class="ml-auto font-bold text-lg text-teal-700 mt-2 sm:mt-0 text-sm sm:text-base">
                    Total: {{ number_format($versements->where('validation','1')->sum('montant'), 2) }} MAD
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="bg-white rounded shadow p-3 sm:p-4">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700">Versements Validés</h3>
                    <p class="text-xl sm:text-2xl font-bold text-green-600 mt-1 sm:mt-2">
                        {{ number_format($versements->where('validation', '1')->sum('montant'), 2) }} MAD
                    </p>
                </div>
                <div class="bg-white rounded shadow p-3 sm:p-4">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700">Demandes en attente</h3>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-600 mt-1 sm:mt-2">
                        {{ $versements->where('validation', '0')->count() }} demandes
                    </p>
                </div>
                <div class="bg-white rounded shadow p-3 sm:p-4">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700">Total des Versements</h3>
                    <p class="text-xl sm:text-2xl font-bold text-blue-600 mt-1 sm:mt-2">
                        {{ number_format($versements->sum('montant'), 2) }} MAD
                    </p>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:gap-4">
                <div id="toggleContainer" class="flex justify-center mb-3 sm:mb-4">
                    <button id="tableToggle" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-1 sm:py-2 px-3 sm:px-4 rounded transition duration-200 text-sm sm:text-base">
                        Afficher les Versements Standards
                    </button>
                </div>

                <!-- Standards Section -->
                <div id="standardsSection" class="mb-6 sm:mb-8 bg-white p-3 sm:p-4 rounded shadow" style="display: none;">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800">Versements Standards</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-left text-xs sm:text-sm">
                                    <th class="py-2 px-2 sm:px-4 border">Recu</th>
                                    <th class="py-2 px-2 sm:px-4 border">Vendeur</th>
                                    <th class="py-2 px-2 sm:px-4 border">Montant</th>
                                    <th class="py-2 px-2 sm:px-4 border">Date</th>
                                    @canany(['admin', 'df'])
                                    <th class="py-2 px-2 sm:px-4 border">validation</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($versements->where('validation', '1') as $versement)
                                    <tr class="border-b hover:bg-gray-50 text-xs sm:text-sm">
                                        <td class="py-2 px-2 sm:px-4">
                                            @if($versement->image)
                                                <img src="{{ asset('storage/' . $versement->image) }}" alt="Reçu" class="h-8 sm:h-12 cursor-pointer" onclick="window.open('{{ asset('storage/' . $versement->image) }}', '_blank')">
                                            @else
                                                <span class="text-xs text-gray-400">Aucune image</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-2 sm:px-4">{{ $versement->vendeur }}</td>
                                        <td class="py-2 px-2 sm:px-4">{{ number_format($versement->montant, 2) }} MAD</td>
                                        <td class="py-2 px-2 sm:px-4">{{ $versement->created_at->format('d/m/Y H:i') }}</td>
                                        @canany(['admin','df'])
                                        <td class="py-2 px-2 sm:px-4">
                                            <form action="{{ route('verement.update', $versement->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-0">
                                                    <label class="inline-flex items-center mr-1 sm:mr-3">
                                                        <input type="radio" name="validation" value="1" {{ $versement->validation == "1" ? "checked" : "" }} class="form-radio text-blue-500 h-3 w-3 sm:h-4 sm:w-4">
                                                        <span class="ml-1 text-xs sm:text-sm">Validé</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="validation" value="0" {{ $versement->validation == "0" ? "checked" : "" }} class="form-radio text-red-500 h-3 w-3 sm:h-4 sm:w-4">
                                                        <span class="ml-1 text-xs sm:text-sm">En attente</span>
                                                    </label>
                                                    <button type="submit" class="ml-0 sm:ml-4 mt-1 sm:mt-0 px-2 sm:px-3 py-0 sm:py-1 bg-blue-500 text-white text-xs sm:text-sm rounded hover:bg-blue-600">
                                                        Mettre à jour
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        @endcanany
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-3 px-3 sm:px-4 text-center text-gray-500 text-xs sm:text-sm">Aucun versement standard trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Demandes Section -->
                <div id="demandesSection" class="bg-white p-3 sm:p-4 rounded shadow">
                    <div class="flex flex-col sm:flex-row justify-between gap-2 sm:gap-0">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-4">Demandes de Versements</h2>
                        @canany(["comm"])
                            <a href="{{ route('verement.create') }}" class="bg-green-500 text-white px-3 sm:px-4 py-1 sm:py-2 rounded hover:bg-green-600 transition duration-200 text-sm sm:text-base text-center">
                                + Nouveau versement
                            </a>
                        @endcanany
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-left text-xs sm:text-sm">
                                    <th class="py-2 px-2 sm:px-4 border">Image</th>
                                    @canany(['admin','df'])<th class="py-2 px-2 sm:px-4 border">Vendeur</th>@endcanany
                                    <th class="py-2 px-2 sm:px-4 border">Montant</th>
                                    @canany(['admin','df'])<th class="py-2 px-2 sm:px-4 border">Validation</th>@endcanany
                                    <th class="py-2 px-2 sm:px-4 border">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($versements->where('validation', '0') as $versement)
                                <tr class="border-b hover:bg-gray-50 text-xs sm:text-sm">
                                    <td class="py-2 px-2 sm:px-4">
                                        @if($versement->image)
                                            <img src="{{ asset('storage/' . $versement->image) }}" alt="Reçu" class="h-8 sm:h-12 cursor-pointer" onclick="window.open('{{ asset('storage/' . $versement->image) }}', '_blank')">
                                        @else
                                            <span class="text-xs text-gray-400">Aucune image</span>
                                        @endif
                                    </td>
                                    @canany(['admin','df'])<td class="py-2 px-2 sm:px-4">{{ $versement->vendeur }}</td>@endcanany
                                    <td class="py-2 px-2 sm:px-4">{{ number_format($versement->montant, 2) }} MAD</td>
                                    @canany(['admin','df'])
                                    <td class="py-2 px-2 sm:px-4">
                                        <form action="{{ route('verement.update', $versement->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-0">
                                                <label class="inline-flex items-center mr-1 sm:mr-3">
                                                    <input type="radio" name="validation" value="1" {{ $versement->validation == "1" ? "checked" : "" }} class="form-radio text-blue-500 h-3 w-3 sm:h-4 sm:w-4">
                                                    <span class="ml-1 text-xs sm:text-sm">Validé</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="validation" value="0" {{ $versement->validation == "0" ? "checked" : "" }} class="form-radio text-red-500 h-3 w-3 sm:h-4 sm:w-4">
                                                    <span class="ml-1 text-xs sm:text-sm">En attente</span>
                                                </label>
                                                <button type="submit" class="ml-0 sm:ml-4 mt-1 sm:mt-0 px-2 sm:px-3 py-0 sm:py-1 bg-blue-500 text-white text-xs sm:text-sm rounded hover:bg-blue-600">
                                                    Mettre à jour
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    @endcanany
                                    <td class="py-2 px-2 sm:px-4">{{ $versement->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-3 px-3 sm:px-4 text-center text-gray-500 text-xs sm:text-sm">Aucune demande trouvée.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("tableToggle");
            const standardsSection = document.getElementById("standardsSection");

            toggleBtn.addEventListener("click", function () {
                const isVisible = standardsSection.style.display === "block";
                standardsSection.style.display = isVisible ? "none" : "block";
                toggleBtn.textContent = isVisible ? "Afficher les Versements Standards" : "Cacher les Versements Standards";
            });
        });
    </script>
</x-app-layout>