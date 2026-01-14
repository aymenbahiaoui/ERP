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
        Schema::create('caises', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('numero_facture');
            $table->string('client')->nullable();
            $table->string('vendeur')->nullable();
            $table->decimal('total_valeur', 12, 2)->default(0);
            $table->string('mode_de_paiement')->default('espece');
            $table->decimal('cheque_details', 12, 2)->default(0)->nullable();
            $table->decimal('espece_details', 12, 2)->default(0)->nullable();
            $table->decimal('instance_details', 12, 2)->default(0)->nullable();
            $table->decimal('montant_payant',12,2)->default(0);
            $table->decimal('montant_reste',12,2)->default(0);
            $table->boolean('validation')->default(0);
            $table->boolean('validationComm')->default(0);
            $table->text('observation')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caises');
    }
};
