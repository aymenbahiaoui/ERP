<?php

namespace App\Imports;

use App\Models\CaModel;
use App\Models\CaiseModel;
use App\Models\StockModel;
use App\Models\CommerciauxModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CaImport implements ToModel, WithHeadingRow
{
    private $factures = [];
    private $stockUpdates = [];
    private $commerciaux = [];

    public function model(array $row)
    {
        
        try {
            $date = is_numeric($row['date'])
                ? $this->transformDate($row['date'])->format('Y-m-d')
                : Carbon::parse($row['date'])->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error("Date conversion error: " . $e->getMessage(), $row);
            return null;
        }

        $numeroFacture = $row['nfacture'] ?? $row['numerofacture'] ?? $row['numero_facture'] ?? null;
        $codeClient = $row['code_client'] ?? null;
        $codeArticle = $row['code_article'] ?? null;
        $qteCde = floatval($row['qte_cde_unite'] ?? 0);
        $valeurFact = floatval($row['valeur_fact'] ?? 0);
        $designation = $row['designation'] ?? null;
        $categorie = $row['categorie'] ?? null;
        $vendeur = $row['vendeur'] ?? null;

        
        if ($vendeur) {
            $this->commerciaux[$vendeur] = [
                'vendeur' => $vendeur,
                'nom' => $row['nom_vendeur'] ?? $vendeur
            ];
        }

        
        if ($numeroFacture && $codeClient && $codeArticle) {
            $exists = CaModel::where([
                ['date', '=', $date],
                ['numero_facture', '=', $numeroFacture],
                ['code_client', '=', $codeClient],
                ['code_article', '=', $codeArticle],
                ['qte_cde', '=', $qteCde],
                ['valeur_fact', '=', $valeurFact],
            ])->exists();

            if ($exists) {
                Log::info("Row ignored: already exists", $row);
                return null;
            }
        }

        
        $caModel = new CaModel([
            'date' => $date,
            'distributeur' => $row['distributeur'] ?? null,
            'canal' => $row['canal'] ?? null,
            'vendeur' => $vendeur,
            'code_client' => $codeClient,
            'client' => $row['client'] ?? null,
            'secteur' => $row['secteur'] ?? null,
            'tournee' => $row['tournee'] ?? null,
            'ville' => $row['ville'] ?? null,
            'categorie_client' => $row['categorie_client'] ?? null,
            'numero_facture' => $numeroFacture,
            'numero_livraison' => $row['n_livraison'] ?? $row['numero_livraison'] ?? null,
            'famille' => $row['famille'] ?? null,
            'categorie' => $categorie,
            'code_article' => $codeArticle,
            'designation' => $designation,
            'qte_cde' => $qteCde,
            'valeur_cde' => floatval($row['valeur_cde'] ?? 0),
            'qte_fact' => floatval($row['qte_fact_unite'] ?? 0),
            'valeur_fact' => $valeurFact,
            'qte_cde_retour' => floatval($row['qte_cde_retour_unite'] ?? 0),
            'valeur_cde_retour' => floatval($row['valeur_cde_retour'] ?? 0),
            'qte_fact_retour' => floatval($row['qte_fact_retour_unite'] ?? 0),
            'valeur_fact_retour' => floatval($row['valeur_fact_retour'] ?? 0),
            'gratuite' => $row['gratuite'] ?? null,
        ]);

        
        if ($numeroFacture) {
            $this->factures[$numeroFacture]['total_valeur'] = ($this->factures[$numeroFacture]['total_valeur'] ?? 0) + $valeurFact;
            $this->factures[$numeroFacture]['date'] = $date;
            $this->factures[$numeroFacture]['client'] = $row['client'] ?? '';
            $this->factures[$numeroFacture]['vendeur'] = $vendeur;
        }

        
        if ($codeArticle && $designation && $categorie) {
            $key = $codeArticle . '_' . $categorie;
            
            $this->stockUpdates[$key] = [
                'date' => $date,
                'categorie' => $categorie,
                'produit' => $designation,
                'ventre' => ($this->stockUpdates[$key]['ventre'] ?? 0) + $qteCde,
            ];
        }

        return $caModel;
    }

    public function __destruct()
    {
        
        foreach ($this->commerciaux as $commercialData) {
            CommerciauxModel::updateOrCreate(
                ['vendeur' => $commercialData['vendeur']],
                ['nom' => ""]
            );
        }

        
        foreach ($this->factures as $numero => $data) {
            CaiseModel::updateOrCreate(
                ['numero_facture' => $numero],
                [
                    'date' => $data['date'],
                    'client' => $data['client'],
                    'vendeur' => $data['vendeur'],
                    'total_valeur' => $data['total_valeur'],
                    'espece_details' => $data['total_valeur'],
                    'mode_de_paiement' => 'espece',
                    'observation' => null,
                ]
            );
        }

        
        foreach ($this->stockUpdates as $key => $stockData) {
            $stock = StockModel::firstOrNew([
                'produit' => $stockData['produit'],
                'categorie' => $stockData['categorie'],
            ]);

            $stock->date = $stockData['date'];
            $stock->ventre = ($stock->ventre ?? 0) + $stockData['ventre'];
            $stock->save();
        }
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\Throwable $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }
}