<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportationsModel extends Model
{
    protected $table = 'importations';

    protected $fillable = [
        'sku_id',
        'order_number',
        'invoice_number',
        'invoice_date',
        'paid_quantity',
        'free_quantity',
        'total_quantity',
        'cost_fob',
        'transportation',
        'custom_duty',
        'others',
        'cout_total',
        'cout_unit',
        'montant_en_dh',
        'echange',
        'taux',
        'paiment', 
        'reste',
        'date_darivee',
        'date_dechange'
    ];

    public function sku()
    {
        return $this->belongsTo(SkuModel::class, 'sku_id');
    }
}