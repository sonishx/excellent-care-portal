<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUserActivityTable extends Migration
{
    public function up(): void
    {
        Schema::table('user_activity', function (Blueprint $table) {
            $table->string('role')->nullable()->after('user_id'); // Add role column
        });
    }

    public function down(): void
    {
        Schema::table('user_activity', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}