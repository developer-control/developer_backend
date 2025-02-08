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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('project_unit_id')->nullable()->index();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->date('date')->nullable()->index();
            $table->string('invoice_code')->nullable()->index();
            $table->string('status')->nullable()->index()->comment('request, cancel, reject, paid');
            $table->double('total')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bill_payment', function (Blueprint $table) {
            $table->foreignId('bill_id')->constrained('bills');
            $table->foreignId('payment_id')->constrained('payments');
            $table->primary(['bill_id', 'payment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payment');
        Schema::dropIfExists('payments');
    }
};
