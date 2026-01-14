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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('produit'); 
            $table->decimal('janvier', 10, 2)->nullable();
            $table->decimal('février', 10, 2)->nullable();
            $table->decimal('mars', 10, 2)->nullable();
            $table->decimal('avril', 10, 2)->nullable();
            $table->decimal('mai', 10, 2)->nullable();
            $table->decimal('juin', 10, 2)->nullable();
            $table->decimal('juillet', 10, 2)->nullable();
            $table->decimal('août', 10, 2)->nullable();
            $table->decimal('septembre', 10, 2)->nullable();
            $table->decimal('octobre', 10, 2)->nullable();
            $table->decimal('novembre', 10, 2)->nullable();
            $table->decimal('décembre', 10, 2)->nullable();
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
