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
        Schema::create('instrumentos', function (Blueprint $table) {
            $table->id('id_instrumento');
            $table->string('instrumento', 50)
               ->unique();
            $table->enum('nivel', ['inicio', 'intermedio', 'avanzado'])
               ->default('inicio');
            $table->enum('categoria', ['principiante','profesional','escenario'])
               ->default('principiante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrumentos');
    }
};
