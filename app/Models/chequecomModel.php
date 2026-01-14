<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChequecomModel extends Model
{
    protected $table = 'chequeoms';

    protected $fillable = [
        'datebl',
        'image',
        'montantpayant',
        'montantbl',
        'instance',
        'vendeur',
        'bl',
        'datepaiment',
        'datedecheance',
        'nombre_jours',
        'validation'
    ];
}
