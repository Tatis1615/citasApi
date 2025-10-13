<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter enum to include 'completado'
        // Note: MySQL ENUM alters require full list replacement
        DB::statement("ALTER TABLE citas MODIFY COLUMN estado ENUM('pendiente','confirmada','cancelada','completado') NOT NULL");
    }

    public function down(): void
    {
        // Remove 'completado' from enum
        DB::statement("ALTER TABLE citas MODIFY COLUMN estado ENUM('pendiente','confirmada','cancelada') NOT NULL");
    }
};
