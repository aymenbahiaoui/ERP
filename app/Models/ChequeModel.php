<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChequeModel extends Model

{
    protected $table = 'cheques';
    protected $fillable = [
        'date1',
        'N_cheque',
        'numero_facture_id',
        'client_id',
        'vendeur_id',
        'montant_id',
        'etat',
        'date2'
    ];

    public function client()
    {
        return $this->belongsTo(CaiseModel::class, 'client_id');
    }

    public function vendeur()
    {
        return $this->belongsTo(CaiseModel::class, 'vendeur_id');
    }

    public function montant()
    {
        return $this->belongsTo(CaiseModel::class, 'montant_id');
    }
    public function facture()
    {
        return $this->belongsTo(CaiseModel::class, 'numero_facture_id');
    }
}
