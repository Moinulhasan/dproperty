<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Indexes only (no column changes) for the homepage property queries:
 * rent/sell sections filter status + property_status, the featured section
 * filters status + is_home_featured; all order by created_at desc.
 * FK columns used in whereIn lookups are already indexed by their foreign keys.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->index(['status', 'property_status', 'created_at'], 'properties_status_property_status_created_at_index');
            $table->index(['status', 'is_home_featured', 'created_at'], 'properties_status_home_featured_created_at_index');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('properties_status_property_status_created_at_index');
            $table->dropIndex('properties_status_home_featured_created_at_index');
        });
    }
};
