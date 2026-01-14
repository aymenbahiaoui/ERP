<?php

namespace App\Imports;

use App\Models\ImpotModel;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class ImpotImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImpotModel([
                'date'       => $this->parseDate($row['date'] ?? null),
                'categorie'  => $this->parseString($row['categorie'] ?? null),
                'produit'    => $this->parseString($row['produit'] ?? null),
                'qte'        => $this->parseNumber($row['qte'] ?? null),
                'si'         => $this->parseNumber($row['si'] ?? null),
                'recept'     => $this->parseNumber($row['recept'] ?? null),
                'ventre'     => $this->parseNumber($row['ventre'] ?? null),
                'charge'     => $this->parseNumber($row['charge'] ?? null),
                'decharge'   => $this->parseNumber($row['decharge'] ?? null),
                'sf'         => $this->parseNumber($row['sf'] ?? null),
                'autre'      => $this->parseNumber($row['autre'] ?? null),
                'import'     => 1,
                'created_at' => now(),
                'updated_at' => now()
        ]);
        
    }
    private function parseDate($date)
    {
        if (empty($date)) return null;
        
        try {
            if (is_numeric($date)) { 
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
            }
            return \Carbon\Carbon::parse($date);
        } catch (\Exception $e) {
            Log::error("Date parsing error: ".$e->getMessage());
            return null;
        }
    }

    private function parseString($value)
    {
        return is_string($value) ? trim($value) : null;
    }

    private function parseNumber($value)
    {
        return is_numeric($value) ? $value : 0;
    }
}
