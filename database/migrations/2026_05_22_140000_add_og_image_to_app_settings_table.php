<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('app_settings', 'og_image')) {
            Schema::table('app_settings', function (Blueprint $table) {
                $table->string('og_image')->nullable()->after('favicon');
            });
        }
    }

    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            if (Schema::hasColumn('app_settings', 'og_image')) {
                $table->dropColumn('og_image');
            }
        });
    }
};
