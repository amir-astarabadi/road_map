<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\Question;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answershits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class, 'exam_id');
            $table->foreignIdFor(Answer::class, 'answer_id')->nullable();
            $table->foreignIdFor(Question::class, 'question_id');
            $table->unsignedTinyInteger('score')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answershits');
    }
};
