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
        // rows remain consistent with the new direct relation. Uses a portable
        // subquery so MySQL, MariaDB, PostgreSQL, and SQLite (3.33+) all
        // accept it — the MySQL "UPDATE … INNER JOIN" syntax is not portable
        // and breaks SQLite-backed test runs.
        DB::statement('
            UPDATE properties
            SET company_id = (
                SELECT users.company_id
                FROM users
                WHERE users.id = properties.created_by
            )
            WHERE company_id IS NULL
              AND created_by IS NOT NULL
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
