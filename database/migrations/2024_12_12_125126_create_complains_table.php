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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->unsignedBigInteger('project_area_id')->nullable()->index();
            $table->unsignedBigInteger('project_unit_id')->nullable()->index();
            $table->string('title')->nullable()->index();
            $table->text('images')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable()->comment('unit, lingkungan, lainnya')->index();
            $table->string('status')->nullable()->index()->comment('request, finished');
            $table->unsignedBigInteger('solved_by')->nullable()->index();
            $table->timestamp('solved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complains');
    }
};
