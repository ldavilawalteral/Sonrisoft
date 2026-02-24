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
        $tables = ['users', 'patients', 'products', 'unit_types'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'clinic_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    // Drop foreign key first
                    $table->dropForeign(['clinic_id']);

                    // For patients, there is a unique index ['clinic_id', 'dni']
                    if ($tableName === 'patients') {
                        $table->dropUnique(['clinic_id', 'dni']);
                    }

                    $table->dropColumn('clinic_id');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-adding columns in down is complex without knowing exact previous state,
        // effectively this is a one-way migration for cleanup.
        // But for correctness we should try to add them back nullable.

        $tables = ['users', 'patients', 'products', 'unit_types'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'clinic_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('clinic_id')->nullable()->constrained('clinics')->onDelete('cascade');
                });
            }
        }
    }
};
