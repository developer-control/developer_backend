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
        Schema::create('developer_feature', function (Blueprint $table) {
            $table->foreignId('developer_id')->constrained('developers');
            $table->foreignId('feature_id')->constrained('features');
            $table->primary(['developer_id', 'feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_feature');
    }
};
