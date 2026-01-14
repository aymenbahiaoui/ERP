<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersementModel extends Model
{
    protected $table = 'versements'; 

    protected $fillable = ['vendeur', 'image', 'montant','validation'];

    // public function caise()
    // {
    //     return $this->belongsTo(CaiseModel::class, 'vendeur');
    // }
}
