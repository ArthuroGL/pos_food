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
            $table->string('apellido_p', 30)->after('name');
            $table->string('apellido_m', 30)->after('apellido_p');
            $table->unsignedTinyInteger('edad')->after('apellido_m');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->after('edad');
            $table->string('tipo_sangre', 5)->nullable()->after('genero');
            $table->string('alergias')->nullable()->after('tipo_sangre');
            $table->string('curp', 18)->unique()->after('alergias');
            $table->string('phone', 10)->nullable()->after('curp');
            $table->string('mobile', 10)->nullable()->after('phone'); // 0: Mesero, 1: Cocina, 2: Admin
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
                'phone',
                'mobile',
            ]);
        });
    }
};
