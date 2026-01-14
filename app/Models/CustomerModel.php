<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $fillable = [
        'produit',
        'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre',
    ];
    protected $table = "customers";
    public function setAttribute($key, $value)
    {
        if (is_string($value) && $value === '') {
            $value = null;
        }
        
        return parent::setAttribute($key, $value);
    }

    public function toArray()
    {
        return array_filter(parent::toArray(), function ($value) {
            return !is_null($value);
        });
    }
}
