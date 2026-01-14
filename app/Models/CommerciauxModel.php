<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommerciauxModel extends Model
{
    protected $table ="commerciauxs";
    protected $fillable = ["vendeur","nom"];
}
