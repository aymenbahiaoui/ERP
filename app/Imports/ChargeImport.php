<?php

namespace App\Imports;

use App\Models\ChargeModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChargeImport implements ToModel
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (isset($row[0]) && $row[0] === 'Produit') {
            return null;
        }

        $produit = $row[0] ?? null;
        $qtePrec = $row[2] ?? null;
        $qteAct = $row[3] ?? null;
        $document = $row[7] ?? null;

        if (!$produit || $qtePrec === null || $qteAct === null || !$document) {
            Log::warning('Champs manquants:', $row);
            return null;
        }

        $mouvement = $qteAct - $qtePrec;
        $charge = 0;
        $decharge = 0;

        if (stripos($document, 'chargement') !== false) {
            $charge = abs($mouvement);
        } elseif (stripos($document, 'déchargement') !== false) {
            $decharge = abs($mouvement);
        }

        // Check if product already exists and update
        $existing = ChargeModel::where('produit', $produit)->first();

        if ($existing) {
            $existing->charge += $charge;
            $existing->decharge += $decharge;
            $existing->save();
            return null; // don't create a new model
        }

        return new ChargeModel([
            'produit' => $produit,
            'charge' => $charge,
            'decharge' => $decharge,
        ]);
    }
}
