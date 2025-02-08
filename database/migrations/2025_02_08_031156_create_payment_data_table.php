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
        Schema::create('payment_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->nullable()->index();
            $table->unsignedBigInteger('developer_bank_id')->nullable()->index();
            $table->string('bank_origin_name')->nullable();
            $table->string('account_origin_name')->nullable();
            $table->string('account_origin_number')->nullable();
            $table->text('description')->nullable();
            $table->text('file_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_data');
    }
};
