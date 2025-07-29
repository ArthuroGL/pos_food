<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comanda_producto', function (Blueprint $table) {
            $table->string('estado')->default('pendiente')->after('comentarios');
        });
    }

    public function down(): void
    {
        Schema::table('comanda_producto', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
