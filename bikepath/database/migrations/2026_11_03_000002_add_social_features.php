<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('name');
            $table->string('bike_type')->nullable();
            $table->string('cycling_level')->default('beginner'); 
            $table->text('address')->nullable();
            $table->string('avatar')->nullable(); 
        });


        Schema::table('aktivitas', function (Blueprint $table) {
            $table->string('judul')->nullable()->after('jalur_sepeda_id');
        });


        Schema::create('komunitas_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komunitas_id')->constrained('komunitas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['komunitas_id', 'user_id']);
        });


        Schema::create('komunitas_pesan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komunitas_id')->constrained('komunitas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('pesan');
            $table->timestamps();
        });


        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'friend_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
        Schema::dropIfExists('komunitas_pesan');
        Schema::dropIfExists('komunitas_user');

        Schema::table('aktivitas', function (Blueprint $table) {
            $table->dropColumn('judul');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'bike_type', 'cycling_level', 'address', 'avatar']);
        });
    }
};
