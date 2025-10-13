<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->foreignId('consultorio_id')->nullable()->after('especialidad_id')->constrained('consultorios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('consultorio_id');
        });
    }
};
