<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Legacy columns from the original schema that the current admin form
     * no longer exposes directly:
     *   - area / bedrooms / bathrooms → replaced by the dynamic
     *     `property_detail_values` system, so the column may be NULL.
     *   - link → unused legacy slot, not surfaced anywhere.
     *
     * Loosening these to nullable lets the controller's validation honestly
     * mark only the fields the user actually fills in as required, instead
     * of having to fake placeholder values to satisfy the schema.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('link')->nullable()->change();
            $table->integer('area')->nullable()->change();
            $table->integer('bedrooms')->nullable()->change();
            $table->integer('bathrooms')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Backfill any nulls with sensible defaults before re-applying
            // NOT NULL so the change() doesn't fail on existing data.
            \DB::table('properties')->whereNull('link')->update(['link' => '#']);
            \DB::table('properties')->whereNull('area')->update(['area' => 0]);
            \DB::table('properties')->whereNull('bedrooms')->update(['bedrooms' => 0]);
            \DB::table('properties')->whereNull('bathrooms')->update(['bathrooms' => 0]);

            $table->string('link')->nullable(false)->change();
            $table->integer('area')->nullable(false)->change();
            $table->integer('bedrooms')->nullable(false)->change();
            $table->integer('bathrooms')->nullable(false)->change();
        });
    }
};
