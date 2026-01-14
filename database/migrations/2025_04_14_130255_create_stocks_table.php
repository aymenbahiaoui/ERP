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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('si')->nullable();
            $table->string('date')->nullable();
            $table->string('categorie')->nullable();
            $table->string('produit')->nullable();
            $table->string('qte')->nullable();
            $table->string('recept')->nullable();
            $table->string('ventre')->nullable();
            // $table->string('charge')->nullable();
            // $table->string('decharge')->nullable();
            $table->double('charge')->nullable();
$table->double('decharge')->nullable();

            $table->string('sf')->nullable();
            $table->string('import')->nullable();
            $table->string('inventaire')->nullable();
            $table->string('ecart')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
