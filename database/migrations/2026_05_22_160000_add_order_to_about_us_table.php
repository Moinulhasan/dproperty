<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('about_us', 'order')) {
            Schema::table('about_us', function (Blueprint $table) {
                $table->unsignedInteger('order')->default(0)->after('status')->index();
            });
        }
    }

    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            if (Schema::hasColumn('about_us', 'order')) {
                $table->dropIndex(['order']);
                $table->dropColumn('order');
            }
        });
    }
};
