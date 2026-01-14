<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'si',
        'date',
        'categorie',
        'produit',
        'qte',
        'recept',
        'ventre',
        'charge',
        'decharge',
        'sf',
        'import',
        'inventaire',
        'ecart',
    ];

    protected $casts = [
        'date' => 'date',
        'qte' => 'decimal:2',
        'si' => 'decimal:2',
        'recept' => 'decimal:2',
        'ventre' => 'decimal:2',
        'charge' => 'decimal:2',
        'decharge' => 'decimal:2',
        'sf' => 'decimal:2',
        'ecart' => 'decimal:2',
        'inventaire' => 'decimal:2',
        // 'import' => 'boolean',
    ];

    protected $attributes = [
        'si' => 0,
        // 'qte' => 0,
        'recept' => 0,
        'ventre' => 0,
        'charge' => 0,
        'decharge' => 0,
        'sf' => 0,
        // 'import' => false,
        'inventaire' => 0,
        'ecart' => 0,
    ];
}
