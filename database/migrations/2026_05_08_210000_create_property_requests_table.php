<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('want_to', ['Sale', 'Rent'])->default('Sale');
            $table->string('property_type')->nullable(); // Residential / Commercial
            $table->string('property_category')->nullable(); // Apartment, House, etc.
            $table->string('furnished_type')->nullable(); // Full Furnished, Semi Furnished, Non Furnished
            $table->string('facing')->nullable(); // North, East, etc.
            $table->string('sft')->nullable();
            $table->string('price')->nullable();
            $table->text('address')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_requests');
    }
};
