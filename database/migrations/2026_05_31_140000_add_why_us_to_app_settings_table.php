<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('app_settings', 'why_us_title')) {
                $table->string('why_us_title')->nullable()->after('contact_image');
            }
            if (!Schema::hasColumn('app_settings', 'why_us_tagline')) {
                $table->text('why_us_tagline')->nullable()->after('why_us_title');
            }
            // JSON list of {title, description} rows. text column instead of
            // json so it remains portable to SQLite-backed test envs and to
            // MariaDB versions that don't expose a native JSON type.
            if (!Schema::hasColumn('app_settings', 'why_us_items')) {
                $table->longText('why_us_items')->nullable()->after('why_us_tagline');
            }
        });
    }

    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            foreach (['why_us_items', 'why_us_tagline', 'why_us_title'] as $col) {
                if (Schema::hasColumn('app_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
