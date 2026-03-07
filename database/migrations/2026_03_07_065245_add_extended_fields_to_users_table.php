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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->string('phone')->nullable()->after('avatar');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('phone');
            $table->boolean('is_verified')->default(false)->after('status');
            $table->string('whatsapp_number')->nullable()->after('is_verified');
            $table->string('agent_id')->unique()->nullable()->after('whatsapp_number');
            $table->foreignId('company_id')->nullable()->after('agent_id')->constrained('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['avatar', 'phone', 'status', 'is_verified', 'whatsapp_number', 'agent_id', 'company_id']);
        });
    }
};
