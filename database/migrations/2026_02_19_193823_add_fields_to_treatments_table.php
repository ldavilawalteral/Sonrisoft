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
        Schema::table('treatments', function (Blueprint $table) {
            if (!Schema::hasColumn('treatments', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('treatments', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('duration');
            }
            if (!Schema::hasColumn('treatments', 'tenant_id')) {
                $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn(['tenant_id', 'description', 'is_active']);
        });
    }
};
