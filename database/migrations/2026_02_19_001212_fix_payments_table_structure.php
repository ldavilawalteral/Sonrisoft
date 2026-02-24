<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // 1. Agregamos patient_id si no existe
            if (!Schema::hasColumn('payments', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable();
            }

            // 2. Agregamos appointment_id si no existe
            if (!Schema::hasColumn('payments', 'appointment_id')) {
                $table->unsignedBigInteger('appointment_id')->nullable();
            }

            // 3. Agregamos treatment_id si no existe (el error indica que existe pero requiere valor)
            // Nos aseguramos de que pueda ser nulo por si acaso, o simplemente nos aseguramos de enviarlo en el código
            if (!Schema::hasColumn('payments', 'treatment_id')) {
                $table->unsignedBigInteger('treatment_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        // No hacemos nada para evitar borrar datos por accidente
    }
};