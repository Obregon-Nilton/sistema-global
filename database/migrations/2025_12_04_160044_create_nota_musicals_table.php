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
        Schema::create('notas_musicales', function (Blueprint $table) {
            $table->id('id_nota');
            $table->string('nota', 5)->unique();
            $table->enum('tipo', ['natural', 'sostenido', 'bemol'])->default('natural');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_musicales');
    }
};
