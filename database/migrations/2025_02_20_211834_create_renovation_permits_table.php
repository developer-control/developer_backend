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
        Schema::create('renovation_permits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('project_unit_id')->nullable()->index();
            $table->unsignedBigInteger('developer_id')->nullable()->index();
            $table->string('title')->nullable()->index(); // Judul
            $table->text('id_card_photo')->nullable(); // Foto KTP
            $table->text('unit_layout')->nullable(); // Denah Unit
            $table->text('neighborhood_certificate')->nullable(); // Surat Keterangan RT
            $table->text('power_of_attorney')->nullable(); // Surat Kuasa
            $table->text('permit_letter')->nullable(); // Surat Izin
            $table->text('deposit_statement')->nullable(); // Surat Pernyataan Deposit
            $table->text('neighbor_information')->nullable(); // Surat Informasi Tetangga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renovation_permits');
    }
};
