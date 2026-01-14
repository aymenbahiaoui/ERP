<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->date('date1');
            $table->string('N_cheque')->nullable();
        
            $table->unsignedBigInteger('numero_facture_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vendeur_id');
            $table->unsignedBigInteger('montant_id');
            $table->string('etat')->default('en port feiule');
            $table->date('date2');
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('caises')->onDelete('cascade');
            $table->foreign('vendeur_id')->references('id')->on('caises')->onDelete('cascade');
            $table->foreign('montant_id')->references('id')->on('caises')->onDelete('cascade');
            $table->foreign('numero_facture_id')->references('id')->on('caises')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
