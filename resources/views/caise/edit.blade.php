<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Facture') }}
        </h2>
    </x-slot>
    @include('header')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('caise.update', $caise->id) }}" method="POST" id="paymentForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $caise->date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>

                            <div>
                                <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                                <input type="text" name="client" id="client" value="{{ old('client', $caise->client) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>

                            <div>
                                <label for="numero_facture" class="block text-sm font-medium text-gray-700">Numéro Facture</label>
                                <input type="text" name="numero_facture" id="numero_facture" value="{{ old('numero_facture', $caise->numero_facture) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>

                            <div>
                                <label for="valeur_fact" class="block text-sm font-medium text-gray-700">Montant (DH)</label>
                                <input type="number" step="0.01" name="valeur_fact" id="valeur_fact" value="{{ old('valeur_fact', $caise->total_valeur) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>
                            <div>
                                <label for="montant_payant" class="block text-sm font-medium text-gray-700">Montant payant (DH)</label>
                                <input type="number" step="0.01" name="montant_payant" id="montant_payant" value="{{ old('montant_payant', $caise->montant_payant) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>
                            <div>
                                <label for="montant_reste" class="block text-sm font-medium text-gray-700">Montant reste (DH)</label>
                                <input type="number" step="0.01" name="montant_reste" id="montant_reste" value="{{ old('montant_reste', $caise->montant_reste) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mode de Paiement</label>
                                <div class="grid grid-cols-2 gap-4">
                                    
                                    <!-- Chèque -->
                                    <div class="payment-option">
                                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="checkbox" name="mode_de_paiement[]" value="cheque"
                                                class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                                                {{ in_array('cheque', explode(',', old('mode_de_paiement', $caise->mode_de_paiement))) ? 'checked' : '' }}>
                                            <span class="text-gray-700">Chèque</span>
                                        </label>
                                        <input type="text" name="cheque_details" id="cheque_details" value="{{ old('cheque_details', $caise->cheque_details) }}"
                                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            {{ !in_array('cheque', explode(',', old('mode_de_paiement', $caise->mode_de_paiement))) ? 'disabled readonly' : '' }}>
                                    </div>

                                    <!-- Espèce -->
                                    <div class="payment-option">
                                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="checkbox" name="mode_de_paiement[]" value="espece"
                                                class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                                                {{ in_array('espece', explode(',', old('mode_de_paiement', $caise->mode_de_paiement))) ? 'checked' : '' }}>
                                            <span class="text-gray-700">Espèce</span>
                                        </label>
                                        <input type="text" name="espece_details" id="espece_details" value="{{ old('espece_details', $caise->espece_details) }}"
                                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            {{ !in_array('espece', explode(',', old('mode_de_paiement', $caise->mode_de_paiement))) ? 'disabled readonly' : '' }}>
                                    </div>

                                  
                                </div>
                               <div>
                               <h1>Validation</h1>
                               <label class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <input type="radio" name="validation" value="1" 
                                    class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                    {{ $caise->validation == "1" ? "checked" : "" }}>
                                <span class="text-gray-700 font-medium">Validé</span>
                            </label>
                            <label class="flex ml-4 items-center  space-x-2">
                                <input type="radio" name="validation" value="0" 
                                    class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                    {{ $caise->validation == "0" ? "checked" : "" }}>
                                <span class="text-gray-700 font-medium">Non Validé</span>
                            </label>
                                </div>
                               </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('caise.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600 transition-colors">
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700 transition-colors">
                                {{ __('Enregistrer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('paymentForm');
            const checkboxes = form.querySelectorAll('input[type="checkbox"][name="mode_de_paiement[]"]');
            const validationRadios = form.querySelectorAll('input[type="radio"][name="validation"]');
    
            // Payment method elements
            const chequeInput = document.getElementById('cheque_details');
            const especeInput = document.getElementById('espece_details');
            const montantPayant = document.getElementById('montant_payant');
            const montantReste = document.getElementById('montant_reste');
            const montantTotal = document.getElementById('valeur_fact');
    
           
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const detailsInput = form.querySelector(`#${this.value}_details`);
                    if (detailsInput) {
                        if (this.checked) {
                            detailsInput.removeAttribute('disabled');
                            detailsInput.removeAttribute('readonly');
                            detailsInput.value = '0'; 
                        } else {
                            detailsInput.setAttribute('disabled', 'disabled');
                            detailsInput.setAttribute('readonly', 'readonly');
                            detailsInput.value = '';
                        }
                        updatePayments();
                    }
                });
            });
    
            
            function animateField(field) {
                field.classList.add('updated');
                setTimeout(() => field.classList.remove('updated'), 300);
            }
    
            
            function validatePayment(input) {
                const total = parseFloat(montantTotal.value) || 0;
                const currentSum = calculateCurrentPayments();
                
                
                let inputValue = parseFloat(input.value) || 0;
                
                
                const remainingAmount = total - (currentSum - inputValue);
                
                
                if (inputValue > remainingAmount) {
                    input.value = remainingAmount.toFixed(2);
                    showAlert(`Le montant ne peut pas dépasser ${remainingAmount.toFixed(2)} DH`);
                    animateField(input);
                }
                
                
                if (inputValue < 0) {
                    input.value = '0';
                    showAlert("Le montant ne peut pas être négatif");
                    animateField(input);
                }
                
                updatePayments();
            }
    
            
            function calculateCurrentPayments() {
                const cheque = parseFloat(chequeInput.value) || 0;
                const espece = parseFloat(especeInput.value) || 0;
                return cheque + espece;
            }
    
            
            function updatePayments() {
                const total = parseFloat(montantTotal.value) || 0;
                const payant = calculateCurrentPayments();
                const reste = total - payant;
    
                montantPayant.value = payant.toFixed(2);
                montantReste.value = reste.toFixed(2);
    
                
                if (reste <= 0) {
                    montantReste.classList.add('text-green-600');
                    montantReste.classList.remove('text-red-600', 'text-yellow-600');
                } else if (payant > 0) {
                    montantReste.classList.add('text-yellow-600');
                    montantReste.classList.remove('text-red-600', 'text-green-600');
                } else {
                    montantReste.classList.add('text-red-600');
                    montantReste.classList.remove('text-green-600', 'text-yellow-600');
                }
    
                [montantPayant, montantReste].forEach(animateField);
            }
    
            
            function showAlert(message) {
                const existingAlert = document.querySelector('.payment-alert');
                if (existingAlert) existingAlert.remove();
    
                const alert = document.createElement('div');
                alert.className = 'payment-alert fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                alert.textContent = message;
                document.body.appendChild(alert);
    
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            }
    
            
            chequeInput.addEventListener('input', function() {
                validatePayment(this);
            });
    
            especeInput.addEventListener('input', function() {
                validatePayment(this);
            });
    
            
            updatePayments();
    
            
            validationRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const labels = form.querySelectorAll('label[for^="validation"]');
                    labels.forEach(label => {
                        label.classList.remove('bg-indigo-100', 'border-indigo-500');
                    });
                    
                    if (this.checked) {
                        const label = this.closest('label');
                        label.classList.add('bg-indigo-100', 'border-indigo-500');
                    }
                });
            });
        });
    </script>
    

    <style>
        .payment-option {
            transition: all 0.3s ease;
        }
        .payment-option:hover {
            transform: translateY(-2px);
        }
        .payment-option label {
            transition: background-color 0.2s ease;
        }
        .payment-option input[type="checkbox"]:checked + span {
            font-weight: 600;
            color: #4f46e5;
        }
        .payment-option input[type="checkbox"]:checked ~ input {
            border-color: #4f46e5;
            box-shadow: 0 0 0 1px #4f46e5;
        }
    </style>
</x-app-layout>
