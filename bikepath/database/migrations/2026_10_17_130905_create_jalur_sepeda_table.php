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
    Schema::create('jalur_sepeda', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('kota');
        $table->string('titik_awal');
        $table->string('titik_akhir');
        $table->decimal('jarak_km', 6, 2);
        $table->string('tingkat_kesulitan'); // Mudah, Sedang, Sulit
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('jalur_sepeda');
}
};
