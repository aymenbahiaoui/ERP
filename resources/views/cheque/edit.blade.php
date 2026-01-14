<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Edit Cheque') }}
        </h2>
    </x-slot>
    @include('header')
    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
            <form method="POST" action="{{ route('cheque.update', $cheque->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    
                    <div class="bg-gray-50 rounded-md p-4 shadow-sm space-y-2">
                        <div>
                            <span class="text-sm text-gray-500">Client:</span>
                            <p class="text-lg font-medium text-gray-800">{{ $cheque->client->client ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Vendeur:</span>
                            <p class="text-lg font-medium text-gray-800">{{ $cheque->vendeur->vendeur ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Montant:</span>
                            <p class="text-lg font-medium text-gray-800">{{ $cheque->montant->cheque_details ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Date:</span>
                            <p class="text-lg font-medium text-gray-800">{{ $cheque->date1 ?? '-' }}</p>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        
                        <div>
                            <label for="N_cheque" class="block text-sm font-medium text-gray-700">Cheque Number</label>
                            <input type="text" id="N_cheque" name="N_cheque" 
                                   value="{{ old('N_cheque', $cheque->N_cheque) }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('N_cheque')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="date2" class="block text-sm font-medium text-gray-700">Date d'opération</label>
                            <input type="date" id="date2" name="date2" 
                                   value="{{ old('date2', $cheque->date2) }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('date2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div class="md:col-span-2">
                            <label for="etat" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="etat" name="etat"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @php
                                    $options = [  'en port feiule', 'en caissement', 'payés', 'impayée','en garante', 'contre espèce'];
                                @endphp
                                @foreach ($options as $option)
                                    <option value="{{ $option }}" {{ old('etat', $cheque->etat) === $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('etat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="flex justify-end space-x-3">
                        {{-- <a href="{{ route('cheque.index') }}"
                           class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 transition">
                            Cancel
                        </a> --}}
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Modifier
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
