<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeModel extends Model
{
    protected $table = 'stocks';

    protected $fillable = [

        'categorie',
        'produit',
        'charge',
        'decharge',
    ];

}
