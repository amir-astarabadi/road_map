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
        Schema::create('charachters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ai_and_tech');
            $table->string('self_managment');
            $table->string('problem_solving');
            $table->string('leader_ship_and_pepple_skills');
            $table->text('desc');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charachters');
    }
};
