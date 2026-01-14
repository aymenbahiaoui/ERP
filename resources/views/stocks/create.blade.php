<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Stocks') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-gradient-to-br from-teal-50 to-blue-50 min-h-screen">
        @include('header')

       
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                <h3 class="text-2xl font-bold text-teal-800 mb-6 border-b pb-2">Nouvelle Entrée de Stock</h3>
                <form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="border p-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Importer</button>
                </form>
 
            </div>
        </div>

       
    </div>
</x-app-layout>