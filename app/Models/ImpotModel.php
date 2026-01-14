<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpotModel extends Model
{
    protected $table = 'stocks';

    protected $fillable = [

        'categorie',
        'produit',
        'qte',
    ];

    protected $casts = [
        'qte' => 'decimal:2',
     
    ];


}
