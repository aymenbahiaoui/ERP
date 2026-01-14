<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaiseModel extends Model
{
    protected $table = 'caises';

    protected $fillable = [
        'date',
        'numero_facture',
        'client',
        'vendeur',
        'total_valeur',
        'mode_de_paiement',
        'cheque_details',
        'espece_details',
        'instance_details',
        'montant_payant',
        'montant_reste',
        "validation",
        'observation'
    ];

    // public function versements()
    // {
    //     return $this->hasMany(VersementModel::class, 'vendeur');
    // }
}
