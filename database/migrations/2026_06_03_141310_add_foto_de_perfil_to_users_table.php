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
        Schema::table('users', function (Blueprint $table) {
            // Se declara como nullable para que los usuarios existentes no tengan problemas
            // Se coloca después de 'is_role' para mantener el orden visual de la tabla
            $table->string('foto_de_perfil')->nullable()->after('is_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Permite hacer rollback de forma limpia eliminando solo esta columna
            $table->dropColumn('foto_de_perfil');
        });
    }
};
