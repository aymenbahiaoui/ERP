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
        Schema::create('chequeoms', function (Blueprint $table) {
            $table->id();
            $table->date("datebl");
            $table->string("image");
            $table->string("montantpayant");
            $table->string("montantbl");
            $table->string("instance");
            $table->string("vendeur");
            $table->string("bl");
            $table->date("datepaiment");
            $table->date("datedecheance");
            $table->boolean("validation")->default(0);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chequeoms');
    }
};
