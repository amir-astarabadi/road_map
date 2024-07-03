<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Authentication\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->integer('budget')->nullable();
            $table->enum('course_length_type', ['short', 'long'])->nullable();
            $table->enum('course_location_type', ['online', 'offline', 'hybride'])->nullable();
            $table->json('industries')->nullable();
            $table->json('jobs')->nullable();
            $table->string('status', 20)->default('start');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_preferences');
    }
};
