<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('properties', 'apply_watermark')) {
            Schema::table('properties', function (Blueprint $table) {
                // Default 1 preserves current behavior (every uploaded image
                // was being watermarked unconditionally).
                $table->boolean('apply_watermark')->default(1)->after('is_location_featured');
            });
        }
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'apply_watermark')) {
                $table->dropColumn('apply_watermark');
            }
        });
    }
};
