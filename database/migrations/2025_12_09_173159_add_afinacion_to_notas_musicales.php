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
        Schema::table('notas_musicales', function (Blueprint $table) {
            $table->string('afinacion', 50)
                ->nullable() //para no lanzar error
                ->after('tipo'); // la columa estara despues del atributo tipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas_musicales', function (Blueprint $table) {
            $table->dropColumn('afinacion');
        });
    }
};
