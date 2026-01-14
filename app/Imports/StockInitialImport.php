<?php

namespace App\Imports;

use App\Models\StockModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockInitialImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            if (empty($row['produit']) || empty($row['categorie'])) {
                Log::warning('Missing required fields', $row);
                return null;
            }
    
            $stockInitial = isset($row['qte']) ? floatval($row['qte']) : 0;
    
            $existingStock = StockModel::where('produit', $row['produit'])
                                       ->where('categorie', $row['categorie'])
                                       ->first();
    
            if ($existingStock) {
                $existingStock->si = ($existingStock->si ?? 0) + $stockInitial;
    
                if (isset($existingStock->recept)) {
                    $existingStock->sf = $existingStock->si + $existingStock->recept - ($existingStock->ventre ?? 0);
                }
    
                $existingStock->save();
                return null;
            } else {
                return new StockModel([
                    'date' => $row['date'] ?? now()->format('Y-m-d'),
                    'categorie' => $row['categorie'],
                    'produit' => $row['produit'],
                    'si' => $stockInitial,
                    'recept' => $row['received'] ?? 0,
                    'ventre' => $row['ventre'] ?? 0,
                    'sf' => $stockInitial + ($row['received'] ?? 0) - ($row['ventre'] ?? 0),
                    'inventory' => $row['inventory'] ?? 0,
                    'difference' => $row['difference'] ?? 0,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error importing stock initial: " . $e->getMessage(), $row);
            return null;
        }
    }
    
}
