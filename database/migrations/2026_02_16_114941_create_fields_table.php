<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();

            // Nama lapangan (Lapangan 1, Lapangan A, dll)
            $table->string('name');

            // Harga per jam (untuk pricing dynamic)
            $table->integer('price_per_hour');

            // Gambar lapangan
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
