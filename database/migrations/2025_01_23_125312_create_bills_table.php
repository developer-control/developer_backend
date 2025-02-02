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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->unsignedBigInteger('project_unit_id')->nullable()->index();
            $table->unsignedBigInteger('bill_type_id')->nullable()->index();
            $table->unsignedBigInteger('start_value')->nullable();
            $table->unsignedBigInteger('end_value')->nullable();
            $table->date('billed_at')->nullable()->index();
            $table->date('usage_period_at')->nullable()->index();
            $table->unsignedBigInteger('value')->nullable();
            $table->double('tax')->nullable();
            $table->double('penalty')->nullable();
            $table->double('discount')->nullable();
            $table->double('bill_release')->nullable();
            $table->double('penalty_release')->nullable();
            $table->double('paid')->nullable();
            $table->double('total')->nullable();
            $table->string('status')->nullable()->index()->comment('not_paid, paid, cancel, pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
