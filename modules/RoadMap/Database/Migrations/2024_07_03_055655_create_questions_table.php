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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('category')->comment('actually it"s enum handel by QuestionCategoryEnum');
            $table->unsignedTinyInteger('competency')->comment('actually it"s enum handel by CompetencyEnum');
            $table->text('title');
            $table->timestamps();

            // $table->unique(['category', 'competency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
