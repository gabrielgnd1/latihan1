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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->enum('sex', ['pria', 'wanita', 'rahasia']);
            $table->enum('jabatan', ['manager', 'kasir', 'waiters']);

            $table->timestamps();

        });

        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->tinyInteger('status');

            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
        Schema::dropIfExists('notas');
    }
};
