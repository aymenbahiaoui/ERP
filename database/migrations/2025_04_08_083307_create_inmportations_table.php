<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('importations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sku_id')->constrained('skus')->onDelete('cascade')->nullable();
            $table->string('order_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->integer('paid_quantity')->nullable();
            $table->integer('free_quantity')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->decimal('cost_fob', 10, 2)->nullable();
            $table->decimal('transportation', 10, 2)->nullable();
            $table->decimal('custom_duty', 10, 2)->nullable();
            $table->decimal('others', 10, 2)->nullable();
            $table->decimal('cout_total', 10, 2)->nullable();
            $table->decimal('cout_unit', 10, 2)->nullable();
            $table->decimal('montant_en_dh', 10, 2)->nullable();
            $table->decimal('echange', 10, 2)->nullable();
            $table->decimal('taux', 10, 2)->nullable();
            $table->decimal('paiment', 10, 2)->nullable();
            $table->decimal('reste', 10, 2)->nullable();
            $table->date('date_darivee')->nullable();
            $table->date('date_dechange')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('importations');
    }
};
