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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade'); 
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade'); 
            $table->foreignId('consultorio_id')->constrained('consultorios')->onDelete('cascade'); 
            $table->dateTime('fecha_hora');
            $table->enum('estado',['pendiente', 'confirmada', 'cancelada']);
            $table->string('motivo'); 
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
