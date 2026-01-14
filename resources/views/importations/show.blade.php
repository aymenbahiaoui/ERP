<x-app-layout>
   

    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')
        <div class="p-6 text-gray-900 bg-white shadow rounded-md max-w-4xl mx-auto mt-6">
            <h3 class="text-lg font-semibold mb-4">Importation #{{ $item->id }}</h3>
    
            <div class="space-y-2 grid grid-cols-2">
                <p><strong>SKU :</strong> {{ $item->sku?->name ?? 'Non défini' }}</p>
                <p><strong>Numéro de commande :</strong> {{ $item->order_number }}</p>
                <p><strong>Numéro de facture :</strong> {{ $item->invoice_number }}</p>
                <p><strong>Date de facture :</strong> {{ $item->invoice_date }}</p>
                <p><strong>Quantité payée :</strong> {{ $item->paid_quantity }}</p>
                <p><strong>Quantité gratuite :</strong> {{ $item->free_quantity }}</p>
                <p><strong>Quantité totale :</strong> {{ $item->total_quantity }}</p>
                <p><strong>Coût FOB :</strong> {{ $item->cost_fob }}</p>
                <p><strong>Transport :</strong> {{ $item->transportation }}</p>
                <p><strong>Droits de douane :</strong> {{ $item->custom_duty }}</p>
                <p><strong>Autres frais :</strong> {{ $item->others }}</p>
                <p><strong>Coût total :</strong> {{ $item->cout_total }}</p>
                <p><strong>Coût unitaire :</strong> {{ $item->cout_unit }}</p>
                <p><strong>Montant en DH :</strong> {{ $item->montant_en_dh }}</p>
                <p><strong>Échange :</strong> {{ $item->echange }}</p>
                <p><strong>Taux :</strong> {{ $item->taux }}</p>
                <p><strong>Paiement :</strong> {{ $item->paiment }}</p>
                <p><strong>Reste :</strong> {{ $item->reste }}</p>
                <p><strong>Date d’arrivée :</strong> {{ $item->date_darivee }}</p>
                <p><strong>Date d’échange :</strong> {{ $item->date_dechange }}</p>
            </div>
            <a href="{{ route('importations.edit',$item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('importations.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('sure?')">Delete</button>
                            </form>
        </div>
</x-app-layout>