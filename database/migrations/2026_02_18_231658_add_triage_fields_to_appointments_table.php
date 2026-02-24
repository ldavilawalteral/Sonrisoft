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
    Schema::table('appointments', function (Blueprint $table) {
        // Solo agrega vital_signs si no existe previamente
        if (!Schema::hasColumn('appointments', 'vital_signs')) {
            $table->json('vital_signs')->nullable()->after('status');
        }
        
        // Hacemos lo mismo con los demás campos por si acaso
        if (!Schema::hasColumn('appointments', 'triage_alergy')) {
            $table->string('triage_alergy')->nullable();
        }
        
        if (!Schema::hasColumn('appointments', 'triage_pain_level')) {
            $table->integer('triage_pain_level')->nullable();
        }
        
        if (!Schema::hasColumn('appointments', 'triage_notes')) {
            $table->text('triage_notes')->nullable();
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
        });
    }
};
