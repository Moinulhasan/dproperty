<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('properties', 'company_id')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->foreignId('company_id')
                    ->nullable()
                    ->after('created_by')
                    ->constrained('companies')
                    ->nullOnDelete();
            });
        }

        // Backfill existing properties from the creator's company so historical
        // rows remain consistent with the new direct relation.
        DB::statement('
            UPDATE properties p
            INNER JOIN users u ON u.id = p.created_by
            SET p.company_id = u.company_id
            WHERE p.company_id IS NULL
              AND u.company_id IS NOT NULL
        ');
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
