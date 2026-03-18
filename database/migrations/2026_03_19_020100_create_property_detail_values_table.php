<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_detail_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('property_detail_id');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('property_detail_id')->references('id')->on('property_details')->onDelete('cascade');
            $table->unique(['property_id', 'property_detail_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_detail_values');
    }
};
