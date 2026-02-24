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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');

            // Estado (Enum)
            $table->enum('status', [
                'scheduled',
                'waiting',
                'triage',
                'doctor',
                'in_process',
                'finished',
                'cancelled'
            ])->default('scheduled');

            // Campos de datos
            $table->dateTime('scheduled_at');
            $table->text('symptoms')->nullable();
            $table->json('vital_signs')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
