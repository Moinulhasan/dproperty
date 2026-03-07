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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('feature_image')->nullable()->after('images');
            $table->boolean('is_home_featured')->default(false)->after('is_featured');
            $table->boolean('is_location_featured')->default(false)->after('is_home_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['feature_image', 'is_home_featured', 'is_location_featured']);
        });
    }
};
