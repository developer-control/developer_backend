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
        Schema::create('developer_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->text('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_banks');
    }
};
