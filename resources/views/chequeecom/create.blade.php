<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Chèque E-Commerce') }}
        </h2>
    </x-slot>
    
    @include('header')
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Partial Payments Section -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paiements partiels en attente</h3>
                @if($partialPayments->isEmpty())
                    <p class="text-gray-500">Aucun paiement partiel en attente</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BL</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant BL</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant Payé</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reste à payer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $displayedBLs = []; @endphp
                                @foreach($partialPayments as $payment)
                                    @if (!$payment->instance == 0 )
                                        @php $displayedBLs[] = $payment->bl; @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $payment->bl }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($payment->montantbl, 2) }} MAD
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($payment->montantpayant, 2) }} MAD
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                                {{ number_format($payment->instance, 2) }} MAD
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('jj', $payment->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3"
                                                   onclick="return confirm('Continuer le paiement pour BL: {{ $payment->bl }}?')">
                                                   Continuer le paiement
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                @endif
            </div>

            <!-- New Payment Form -->
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('cheques.store') }}" enctype="multipart/form-data" id="paymentForm">
                    @csrf

                    <!-- Amount Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="montantbl" class="block text-sm font-medium text-gray-700 mb-1">Montant BL (MAD)</label>
                            <input type="number" step="0.01" name="montantbl" id="montantbl" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                            <p id="selected-total" class="text-sm text-gray-500 mt-1 hidden">
                                Total sélectionné: <span class="font-medium">0.00</span> MAD
                            </p>
                        </div>
                        <div>
                            <label for="montantpayant" class="block text-sm font-medium text-gray-700 mb-1">Montant Payant (MAD)</label>
                            <input type="number" step="0.01" name="montantpayant" id="montantpayant" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            <p id="payment-error" class="text-sm text-red-600 mt-1 hidden"></p>
                        </div>
                    </div>

                    <!-- Instance Field -->
                    <div class="mb-6">
                        <label for="instance" class="block text-sm font-medium text-gray-700 mb-1">Instance (Auto)</label>
                        <input type="text" name="instance" id="instance" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                    </div>

                    <!-- Date Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label for="datebl" class="block text-sm font-medium text-gray-700 mb-1">Date BL</label>
                            <input type="date" name="datebl" id="datebl"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                        <div>
                            <label for="datepaiment" class="block text-sm font-medium text-gray-700 mb-1">Date Paiement</label>
                            <input type="date" name="datepaiment" id="datepaiment"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                        <div>
                            <label for="datedecheance" class="block text-sm font-medium text-gray-700 mb-1">Date Échéance</label>
                            <input type="date" name="datedecheance" id="datedecheance"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Available Invoices -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Factures Disponibles</label>
                        <div class="border rounded-md p-2 max-h-60 overflow-y-auto">
                            @forelse($factures as $facture)
                                @php
                                    $alreadyUsed = \App\Models\ChequecomModel::where('bl', 'LIKE', "%$facture->numero_facture%")->exists();
                                @endphp
                            
                                @if(!$alreadyUsed)
                                    <div class="flex items-center py-2 px-1 hover:bg-gray-50 rounded">
                                        <input type="checkbox" name="factures[]" value="{{ $facture->numero_facture }}" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded facture-checkbox"
                                               data-value="{{ $facture->total_valeur }}"
                                               data-date="{{ $facture->date_facture }}">
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-900">{{ $facture->numero_facture }}</span>
                                            <span class="text-xs text-gray-500 ml-2">{{ number_format($facture->total_valeur, 2) }} MAD ({{ $facture->date_facture }})</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500">Aucune facture disponible</p>
                            @endforelse
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Total disponible: {{ number_format($factures->sum('total_valeur'), 2) }} MAD
                        </p>
                    </div>

                    <!-- Cheque Image -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image du chèque</label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100" 
                               required>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cheques.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const form = document.getElementById('paymentForm');
            const checkboxes = document.querySelectorAll('.facture-checkbox');
            const montantblInput = document.getElementById('montantbl');
            const montantPayantInput = document.getElementById('montantpayant');
            const instanceInput = document.getElementById('instance');
            const selectedTotalElement = document.getElementById('selected-total');
            const selectedTotalAmount = selectedTotalElement.querySelector('span');
            const paymentErrorElement = document.getElementById('payment-error');
            const dateblInput = document.getElementById('datebl');
            const datepaimentInput = document.getElementById('datepaiment');
            const datedecheanceInput = document.getElementById('datedecheance');
            
            // Initialize dates
            const today = new Date().toISOString().split('T')[0];
            datepaimentInput.value = today;
            
            // Set due date to 30 days from today
            const dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + 30);
            datedecheanceInput.value = dueDate.toISOString().split('T')[0];
            
            // Event Listeners
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updatePaymentDetails);
            });
            
            montantPayantInput.addEventListener('input', validatePaymentAmount);
            form.addEventListener('submit', validateForm);
            
            // Functions
            function updatePaymentDetails() {
                let total = 0;
                let earliestDate = null;
                
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const amount = parseFloat(checkbox.dataset.value);
                        total += amount;
                        
                        // Find earliest invoice date
                        const invoiceDate = new Date(checkbox.dataset.date);
                        if (!earliestDate || invoiceDate < earliestDate) {
                            earliestDate = invoiceDate;
                        }
                    }
                });
                
                // Update BL amount
                montantblInput.value = total.toFixed(2);
                
                // Update selected total display
                if (total > 0) {
                    selectedTotalAmount.textContent = total.toFixed(2);
                    selectedTotalElement.classList.remove('hidden');
                    
                    // Set BL date to earliest invoice date
                    if (earliestDate) {
                        dateblInput.value = earliestDate.toISOString().split('T')[0];
                        
                        // Ensure payment date is not before BL date
                        if (new Date(datepaimentInput.value) < earliestDate) {
                            datepaimentInput.value = earliestDate.toISOString().split('T')[0];
                        }
                    }
                } else {
                    selectedTotalElement.classList.add('hidden');
                    dateblInput.value = '';
                }
                
                // Recalculate instance
                validatePaymentAmount();
            }
            
            function validatePaymentAmount() {
                const montantBL = parseFloat(montantblInput.value) || 0;
                const montantPayant = parseFloat(montantPayantInput.value) || 0;
                
                // Calculate instance
                const instance = montantBL - montantPayant;
                instanceInput.value = instance.toFixed(2);
                
                // Validate payment amount
                if (montantPayant > montantBL) {
                    paymentErrorElement.textContent = "Le montant payant ne peut pas dépasser le montant BL";
                    paymentErrorElement.classList.remove('hidden');
                    montantPayantInput.classList.add('border-red-500');
                    return false;
                } else if (montantPayant <= 0) {
                    paymentErrorElement.textContent = "Le montant payant doit être supérieur à 0";
                    paymentErrorElement.classList.remove('hidden');
                    montantPayantInput.classList.add('border-red-500');
                    return false;
                } else {
                    paymentErrorElement.classList.add('hidden');
                    montantPayantInput.classList.remove('border-red-500');
                    return true;
                }
            }
            
            function validateForm(e) {
                // Check at least one invoice is selected
                const selectedInvoices = document.querySelectorAll('.facture-checkbox:checked').length;
                if (selectedInvoices === 0) {
                    e.preventDefault();
                    alert('Veuillez sélectionner au moins une facture');
                    return false;
                }
                
                // Validate payment amount
                if (!validatePaymentAmount()) {
                    e.preventDefault();
                    return false;
                }
                
                // Validate cheque image is uploaded
                if (!document.getElementById('image').files.length) {
                    e.preventDefault();
                    alert('Veuillez télécharger une image du chèque');
                    return false;
                }
                
                return true;
            }
        });
    </script>
</x-app-layout>