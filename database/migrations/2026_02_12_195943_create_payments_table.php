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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        
        // Creamos las columnas sin forzar la relación estricta en este momento
        $table->unsignedBigInteger('tenant_id'); 
        $table->unsignedBigInteger('patient_id')->nullable();
        $table->unsignedBigInteger('appointment_id')->nullable();
        $table->unsignedBigInteger('treatment_id')->nullable();
        
        $table->decimal('amount', 10, 2);
        $table->string('payment_method')->default('Efectivo');
        $table->date('payment_date')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
