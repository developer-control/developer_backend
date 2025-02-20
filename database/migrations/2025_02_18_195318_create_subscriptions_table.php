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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->index();
            $table->double('price')->nullable()->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('duration')->nullable()->index()->comment('durasi dalam bulan');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('feature_subscription', function (Blueprint $table) {
            $table->foreignId('feature_id')->constrained('features');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->primary(['feature_id', 'subscription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_subscription');
        Schema::dropIfExists('subscriptions');
    }
};
