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
        Schema::create('project_blocs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->unsignedBigInteger('project_area_id')->nullable()->index();
            $table->string('name', 190)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_blocs');
    }
};
