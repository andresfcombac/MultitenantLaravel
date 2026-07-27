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
    Schema::connection('legacy')->table('asistencias', function (Blueprint $table) {

        $table->tinyInteger('estado')
              ->default(0)
              ->after('id_respuesta');

    });
}

public function down(): void
{
    Schema::connection('legacy')->table('asistencias', function (Blueprint $table) {

        $table->dropColumn('estado');

    });
}
};
