<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')
        <div class="p-6 bg-white shadow-md rounded-md max-w-md mx-auto mt-6">
            <h1>ajouter sku</h1>
            <form action="{{ route('sku.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" name="nom" id="sku" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-cyan-200 focus:outline-none">
                </div>
                
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-md">
                        Ajouter
                    </button>
                </div>
            </form>
            <table class="mt-6 w-full text-sm text-left text-gray-600 border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">SKU</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skus as $sku)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $sku->nom }}</td>
                            <td class="px-4 py-2 border flex space-x-2">
                                <a href="{{ route('sku.edit', $sku->id) }}" class="text-blue-600 hover:underline">Modifier</a>
                                <form action="{{ route('sku.destroy', $sku->id) }}" method="POST" onsubmit="return confirm('Supprimer ce SKU ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        

</x-app-layout>
