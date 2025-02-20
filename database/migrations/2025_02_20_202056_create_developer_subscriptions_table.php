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
        Schema::create('developer_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->unsignedBigInteger('subscription_id')->nullable()->index();
            $table->timestamp('paid_at')->nullable()->index();
            $table->date('expired_at')->nullable()->index();
            $table->string('status')->nullable()->index()->comment('active, expired');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_subscription_tables');
    }
};
