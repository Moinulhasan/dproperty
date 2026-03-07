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
            $table->string('title')->after('id');
            $table->string('slug')->unique()->after('title');
            $table->decimal('price', 15, 2)->after('slug');
            $table->string('category')->after('price'); // Residential, Commercial
            $table->renameColumn('type', 'property_type'); // Rename existing column
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_status')->after('property_type'); // For Sale, For Rent
            $table->string('route')->nullable()->after('property_status');
            $table->string('sub_route')->nullable()->after('route');
            $table->string('road')->nullable()->after('sub_route');
            $table->string('lane')->nullable()->after('road');
            $table->string('project_id')->after('lane');
            $table->integer('bedrooms')->nullable()->after('project_id');
            $table->integer('bathrooms')->nullable()->after('bedrooms');
            $table->integer('area')->after('bathrooms'); // in sqft
            $table->string('is_furnished')->after('area'); // Furnished, Semi-Furnished, Unfurnished
            $table->json('images')->nullable()->after('is_furnished');
            $table->string('floor_plan')->nullable()->after('images');
            $table->string('video_link')->nullable()->after('floor_plan');
            $table->text('map_link')->nullable()->after('video_link');
            $table->boolean('is_featured')->default(false)->after('map_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('property_type', 'type');
            $table->dropColumn([
                'title', 'slug', 'price', 'category', 'property_status',
                'route', 'sub_route', 'road', 'lane', 'project_id', 'bedrooms',
                'bathrooms', 'area', 'is_furnished', 'images', 'floor_plan',
                'video_link', 'map_link', 'is_featured'
            ]);
        });
    }
};
