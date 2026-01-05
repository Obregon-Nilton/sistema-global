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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 10)->unique();
            $table->string('telefono', 15)->nullable();
            $table->date('fecha_nacimiento');
            $table->foreignId('rol_id')
               ->constrained('rols', 'id_rol')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
