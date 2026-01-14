<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ca', function (Blueprint $table) {
            $table->id();
            $table->date('Date')->nullable();
            $table->string('distributeur')->nullable();
            $table->string('canal')->nullable();
            $table->string('vendeur')->nullable();
            $table->string('code_client')->nullable();
            $table->string('client')->nullable();
            $table->string('secteur')->nullable();
            $table->string('tournee')->nullable();
            $table->string('ville')->nullable();
            $table->string('categorie_client')->nullable();
            $table->string('numero_facture')->nullable();
            $table->string('numero_livraison')->nullable();
            $table->string('famille')->nullable();
            $table->string('categorie')->nullable();
            $table->string('code_article')->nullable();
            $table->string('designation')->nullable();
            $table->integer('qte_cde')->nullable();
            $table->decimal('valeur_cde', 12, 2)->nullable();
            $table->integer('qte_fact')->nullable();
            $table->decimal('valeur_fact', 12, 2)->nullable();
            $table->integer('qte_cde_retour')->nullable();
            $table->decimal('valeur_cde_retour', 12, 2)->nullable();
            $table->integer('qte_fact_retour')->nullable();
            $table->decimal('valeur_fact_retour', 12, 2)->nullable();
            $table->boolean('gratuite')->nullable();
            
            $table->enum('mode_de_paiement', ['cheque', 'espece', 'instance'])->default('espece');
            $table->string('observation')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca');
    }
};
