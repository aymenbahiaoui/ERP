<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <div class="max-w-5xl mx-auto py-4 sm:py-8 px-4 sm:px-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">
                <h3 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6 text-teal-700">Ajouter une importation</h3>
                
                <form action="{{ route('importations.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <!-- SKU Field -->
                        <div class="relative">
                            <label for="sku_id" class="block text-sm font-medium text-gray-700">SKU</label>
                            <div class="flex items-center mt-1">
                                <select name="sku_id" id="sku_id" class="flex-grow border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" required>
                                    <option value="">Sélectionner un SKU</option>
                                    @foreach($skus as $sku)
                                        <option value="{{ $sku->id }}">{{ $sku->nom }}</option>
                                    @endforeach
                                </select>
                                <a href="{{route('sku.index')}}" class="ml-2">
                                    <button type="button" class="px-3 py-2 sm:px-4 sm:py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-300">
                                        <i class="fas fa-coins text-white"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Basic Information -->
                        <div>
                            <label for="order_number" class="block text-sm font-medium text-gray-700">N° Commande</label>
                            <input type="text" name="order_number" id="order_number" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                        
                        <div>
                            <label for="invoice_number" class="block text-sm font-medium text-gray-700">N° Facture</label>
                            <input type="text" name="invoice_number" id="invoice_number" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                        
                        <div>
                            <label for="invoice_date" class="block text-sm font-medium text-gray-700">Date Facture</label>
                            <input type="date" name="invoice_date" id="invoice_date" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" required>
                        </div>

                        <!-- Quantity Fields -->
                        <div>
                            <label for="paid_quantity" class="block text-sm font-medium text-gray-700">Quantité Payée</label>
                            <input type="number" name="paid_quantity" id="paid_quantity" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="free_quantity" class="block text-sm font-medium text-gray-700">Quantité Gratuite</label>
                            <input type="number" name="free_quantity" id="free_quantity" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="total_quantity" class="block text-sm font-medium text-gray-700">Quantité total</label>
                            <input type="number" name="total_quantity" id="total_quantity" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>

                        <!-- Cost Calculation Fields -->
                        <div>
                            <label for="cost_fob" class="block text-sm font-medium text-gray-700">FOB</label>
                            <input type="number" step="0.01" name="cost_fob" id="cost_fob" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="echange" class="block text-sm font-medium text-gray-700">Taux de change</label>
                            <input type="number" step="0.01" name="echange" id="echange" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="montant_en_dh" class="block text-sm font-medium text-gray-700">Montant en DH</label>
                            <input type="number" step="0.01" name="montant_en_dh" id="montant_en_dh" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>
                        
                        <!-- Additional Costs -->
                        <div>
                            <label for="transportation" class="block text-sm font-medium text-gray-700">Transport</label>
                            <input type="number" step="0.01" name="transportation" id="transportation" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="custom_duty" class="block text-sm font-medium text-gray-700">Droits de Douane</label>
                            <input type="number" step="0.01" name="custom_duty" id="custom_duty" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="others" class="block text-sm font-medium text-gray-700">Autres Coûts</label>
                            <input type="number" step="0.01" name="others" id="others" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <!-- Total Cost -->
                        <div>
                            <label for="cout_total" class="block text-sm font-medium text-gray-700">Cout total</label>
                            <input type="number" step="0.01" name="cout_total" id="cout_total" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>

                        <!-- Unit Cost -->
                        <div>
                            <label for="cout" class="block text-sm font-medium text-gray-700">Cout unitaire</label>
                            <input type="number" name="cout_unit" id="cout" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-3">
                            <hr class="border-gray-300">
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <label for="taux" class="block text-sm font-medium text-gray-700">Taux de paiement (%)</label>
                            <input type="number" step="0.01" name="taux" id="taux" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required oninput="calculateAll()">
                        </div>
                        
                        <div>
                            <label for="paiment" class="block text-sm font-medium text-gray-700">Paiment</label>
                            <input type="number" step="0.01" name="paiment" id="paiment" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>
                        
                        <div>
                            <label for="reste" class="block text-sm font-medium text-gray-700">Reste à payer</label>
                            <input type="number" step="0.01" name="reste" id="reste" 
                                   class="mt-1 w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" 
                                   required readonly>
                        </div>
                        
                        <!-- Date Fields -->
                        <div>
                            <label for="date_darivee" class="block text-sm font-medium text-gray-700">Date d'arrivée</label>
                            <input type="date" name="date_darivee" id="date_darivee" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        
                        <div>
                            <label for="date_dechange" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                            <input type="date" name="date_dechange" id="date_dechange" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 sm:pt-6 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto bg-teal-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-md hover:bg-teal-700 transition duration-300">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calculateAll() {
            calculateTotalQuantity();
            calculateAmountInDH();
            calculateTotalCost();
            calculateUnitCost();
            calculatePaymentAndRemaining();
        }

        function calculateTotalQuantity() {
            const paidQuantity = parseFloat(document.getElementById('paid_quantity').value) || 0;
            const freeQuantity = parseFloat(document.getElementById('free_quantity').value) || 0;
            
            const totalQuantity = paidQuantity + freeQuantity;
            
            document.getElementById('total_quantity').value = totalQuantity;
        }

        function calculateTotalCost() {
            const costFOB = parseFloat(document.getElementById('montant_en_dh').value) || 0;
            const transportation = parseFloat(document.getElementById('transportation').value) || 0;
            const customDuty = parseFloat(document.getElementById('custom_duty').value) || 0;
            const others = parseFloat(document.getElementById('others').value) || 0;
            
            const totalCost = costFOB + transportation + customDuty + others;
            
            document.getElementById('cout_total').value = totalCost.toFixed(2);
        }

        function calculateUnitCost() {
            const totalCost = parseFloat(document.getElementById('cout_total').value) || 0;
            const totalQuantity = parseFloat(document.getElementById('total_quantity').value) || 0;
            
            if (totalQuantity > 0) {
                const unitCost = totalCost / totalQuantity;
                document.getElementById('cout').value = unitCost.toFixed(2);
            } else {
                document.getElementById('cout').value = "0.00";
            }
        }

        function calculateAmountInDH() {
            const costFOB = parseFloat(document.getElementById('cost_fob').value) || 0;
            const exchangeRate = parseFloat(document.getElementById('echange').value) || 0;
            
            const amountInDH = costFOB * exchangeRate;
            
            document.getElementById('montant_en_dh').value = amountInDH.toFixed(2);
        }

        function calculatePaymentAndRemaining() {
            const costFOB = parseFloat(document.getElementById('montant_en_dh').value) || 0;
            const paymentRate = parseFloat(document.getElementById('taux').value) || 0;
            
            const paymentAmount = costFOB * (paymentRate / 100);
            const remainingAmount = costFOB - paymentAmount;
            
            document.getElementById('paiment').value = paymentAmount.toFixed(2);
            document.getElementById('reste').value = remainingAmount.toFixed(2);
        }
    </script>
</x-app-layout>