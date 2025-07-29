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
            // Eliminar campos antiguos si ya no los usarás (opcional)
            $table->dropColumn([
                'email_verified_at',
                'extension',
                'institutional_email'
            ]);

            // Nuevos campos
            $table->string('apellido_p', 30);
            $table->string('apellido_m', 30);
            $table->unsignedTinyInteger('edad');
            $table->enum('genero', ['masculino', 'femenino', 'otro']);
            $table->string('tipo_sangre', 5)->nullable();
            $table->string('alergias')->nullable();
            $table->string('curp', 18)->unique();
            $table->unsignedTinyInteger('is_role'); // 0, 1, 2
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellido_p',
                'apellido_m',
                'edad',
                'genero',
                'tipo_sangre',
                'alergias',
                'curp',
                'is_role'
            ]);
        });
    }
};
