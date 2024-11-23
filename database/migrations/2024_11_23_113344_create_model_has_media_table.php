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
        Schema::create('model_has_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id')->nullable()->index();
            $table->unsignedBigInteger('sourceable_id')->nullable()->index();
            $table->string('sourceable_type')->index()->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_media');
    }
};
