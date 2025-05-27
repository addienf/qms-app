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
        Schema::create('spk_marketing_pics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_marketing_id')->constrained('spk_marketings')->onDelete('cascade');
            $table->string('create_name');
            $table->string('create_signature');
            $table->string('recieve_name');
            $table->string('recieve_signature');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_marketing_pics');
    }
};
