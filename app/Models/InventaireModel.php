<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = 'stocks';
    
    protected $fillable = [
        'categorie',
        'produit',
     
        'inventaire',
     
    ];
    
    protected $casts = [
        'inventaire' => 'float',
    ];
}