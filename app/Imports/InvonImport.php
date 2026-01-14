<?php

namespace App\Imports;

use App\Models\StockModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvonImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Log::info('Traitement ligne inventaire', $row);
        
        try {
            // Check if required fields exist (using numeric indexes or column names)
            $categorie = $row['categorie'] ?? $row[0] ?? null;
            $produit = $row['produit'] ?? $row[1] ?? null;
            $inventaire = $row['inventaire'] ?? $row[2] ?? 0;

            if (empty($categorie) || empty($produit)) {
                Log::warning('Inventaire Import - Missing required fields', $row);
                return null;
            }

            $stock = StockModel::where('produit', $produit)
                             ->where('categorie', $categorie)
                             ->first();

            if ($stock) {
                $stock->inventaire = (float)$inventaire;
                $stock->ecart = ($stock->sf ?? 0) - (float)$inventaire;
                $stock->save();
                Log::info('Inventaire updated successfully', [
                    'produit' => $produit,
                    'categorie' => $categorie,
                    'inventaire' => $inventaire
                ]);
            } else {
                Log::warning('Inventaire Import - Produit non trouvé', [
                    'produit' => $produit,
                    'categorie' => $categorie
                ]);
            }

            return null;

        } catch (\Exception $e) {
            Log::error("Inventaire Import Error: " . $e->getMessage(), $row);
            return null;
        }
    }
}