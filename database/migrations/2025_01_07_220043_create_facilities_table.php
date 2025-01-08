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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->string('title')->nullable()->index();
            $table->text('image')->nullable();
            $table->text('description')->nullable()->fulltext();
            $table->boolean('is_active')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
