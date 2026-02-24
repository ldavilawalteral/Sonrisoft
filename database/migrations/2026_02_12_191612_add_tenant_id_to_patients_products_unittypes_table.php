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
        // Update patients table
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (!Schema::hasColumn('patients', 'tenant_id')) {
                    $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
                }
            });
        }

        // Update products table
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'tenant_id')) {
                    $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
                }
            });
        }

        // Update unit_types table
        if (Schema::hasTable('unit_types')) {
            Schema::table('unit_types', function (Blueprint $table) {
                if (!Schema::hasColumn('unit_types', 'tenant_id')) {
                    $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('patients') && Schema::hasColumn('patients', 'tenant_id')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'tenant_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }

        if (Schema::hasTable('unit_types') && Schema::hasColumn('unit_types', 'tenant_id')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
};
