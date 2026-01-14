<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkuModel extends Model
{
    protected $table = 'skus';
    protected $fillable = ['nom'];
    
    public function importations()
    {
        return $this->hasMany(ImportationsModel::class, 'sku_id');
    }
}