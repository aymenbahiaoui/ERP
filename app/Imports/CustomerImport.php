<?php

namespace App\Imports;

use App\Models\CustomerModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Ajout pour ignorer la première ligne

class CustomerImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new CustomerModel([
            'produit' => $row['produit'] ?? null ,
            'janvier' => $row['janvier'] ?? null ,
            'février' => $row['fevrier'] ?? null ,
            'mars' => $row['mars'] ?? null ,
            'avril' => $row['avril'] ?? null ,
            'mai' => $row['mai'] ?? null ,
            'juin' => $row['juin'] ?? null ,
            'juillet' => $row['juillet'] ?? null ,
            'août' => $row['août'] ?? null ,
            'septembre' => $row['septembre'] ?? null ,
            'octobre' => $row['octobre'] ?? null ,
            'novembre' => $row['novembre'] ?? null ,
            'décembre' => $row['décembre'] ?? null ,
        ]);
    }
}
