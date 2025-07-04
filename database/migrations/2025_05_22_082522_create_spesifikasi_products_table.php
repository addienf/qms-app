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
        Schema::create('spesifikasi_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urs_id')->constrained()->onDelete('cascade');
            $table->boolean('is_stock')->nullable();
            $table->text('detail_specification');
            $table->text('delivery_address')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spesifikasi_products');
    }
};
