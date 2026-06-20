<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['amenities', 'services', 'testimonials'] as $table) {
            if (!Schema::hasColumn($table, 'order')) {
                Schema::table($table, function (Blueprint $t) {
                    // Lower number sorts first on the frontend. Default 0 so
                    // existing rows keep their current insertion order until
                    // an admin re-sequences them.
                    $t->integer('order')->default(0)->after('id');
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['amenities', 'services', 'testimonials'] as $table) {
            if (Schema::hasColumn($table, 'order')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('order');
                });
            }
        }
    }
};
