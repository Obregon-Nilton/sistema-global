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
        Schema::create('interpretaciones', function (Blueprint $table) {
            $table->id('id_interpretacion');

            $table->enum('estado',['inicio', 'intermedio', 'avanzado'])
               ->default('inicio');

            $table->foreignId('nota_id')
               ->nullable()
               ->constrained('notas_musicales','id_nota')
               ->onDelete('set null');

            $table->foreignId('artista_id')
               ->nullable()
               ->constrained('artistas', 'id_artista')
               ->onDelete('set null');

            $table->foreignId('instrumento_id')
               ->nullable()
               ->constrained('instrumentos', 'id_instrumento')
               ->onDelete('set null');

            $table->foreignId('tema_id')
               ->nullable()
               ->constrained('temas', 'id_tema')
               ->onDelete('set null');

            $table->foreignId('genero_id')
               ->nullable()
               ->constrained('generos_musicales', 'id_genero')
               ->onDelete('set null');

            $table->foreignId('musico_id')
               ->constrained('musicos', 'id_musico')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interpretaciones');
    }
};
