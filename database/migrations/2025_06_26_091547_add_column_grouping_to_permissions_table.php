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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('menu')->after('guard_name')->nullable();
            $table->string('group')->after('menu')->index()->nullable();
            $table->integer('type')->after('group')->index()->nullable()->comment('[1:read, 2:create, 3:update, 4:delete, 5:approve/publish/action]');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('menu');
            $table->dropColumn('group');
            $table->dropColumn('type');
        });
    }
};
