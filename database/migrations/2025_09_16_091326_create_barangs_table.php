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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
    $table->string('nama', 100);
    $table->decimal('harga', 8, 0);
    $table->integer('stok');
    $table->text('deskripsi');

    // tambahkan kolom kategori_id
    $table->unsignedBigInteger('kategori_id');

    // lalu foreign key
    $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
