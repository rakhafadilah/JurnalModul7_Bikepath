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
    Schema::create('aktivitas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('jalur_sepeda_id')->constrained('jalur_sepeda')->cascadeOnDelete();
        $table->date('tanggal');
        $table->integer('durasi_menit');
        $table->decimal('jarak_km', 6, 2);
        $table->decimal('kecepatan_rata', 5, 2); // km/jam
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('aktivitas');
}
};
