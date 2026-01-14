<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaModel extends Model
{
    use HasFactory;

    protected $table = 'ca';

    protected $fillable = [
        'date',
        'distributeur',
        'canal',
        'vendeur',
        'code_client',
        'client',
        'secteur',
        'tournee',
        'ville',
        'categorie_client',
        'numero_facture',
        'numero_livraison',
        'famille',
        'categorie',
        'code_article',
        'designation',
        'qte_cde',
        'valeur_cde',
        'qte_fact',
        'valeur_fact',
        'qte_cde_retour',
        'valeur_cde_retour',
        'qte_fact_retour',
        'valeur_fact_retour',
        'gratuite',
    ];
    public function stocks()
    {
        return $this->hasMany(StockModel::class);
    }
}
