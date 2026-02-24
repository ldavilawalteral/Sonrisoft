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
            $table->foreignId('treatment_id')->nullable()->constrained('treatments')->onDelete('set null');

            // Triage specific columns
            $table->text('triage_alergy')->nullable();
            $table->integer('triage_pain_level')->nullable(); // 1-10
            $table->text('triage_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['treatment_id']);
            $table->dropColumn(['treatment_id', 'triage_alergy', 'triage_pain_level', 'triage_notes']);
        });
    }
};
