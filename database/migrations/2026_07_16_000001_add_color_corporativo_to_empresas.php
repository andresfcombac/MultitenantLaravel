<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('legacy')->table('empresas', function (Blueprint $table) {
            $table->string('color_corporativo', 7)
                  ->default('#0d6efd');
        });
    }

    public function down(): void
    {
        Schema::connection('legacy')->table('empresas', function (Blueprint $table) {
            $table->dropColumn('color_corporativo');
        });
    }
};