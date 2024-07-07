<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Models\Career;

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
            $table->foreignIdFor(Career::class, 'career_id')->nullable();
            $table->json('budget')->nullable()->comment('specify min and max budget {min: a, max:b}');
            $table->unsignedTinyInteger('work_experience')->nullable()->comment('actually it"s enum handel by WorkExperienceEnum');
            $table->unsignedTinyInteger('course_format')->nullable()->comment('actually it"s enum handel by CourseFormatEnum');
            $table->unsignedTinyInteger('need_degree')->nullable()->comment('actually it"s enum handel by NeedDegreeEnum');
            $table->unsignedTinyInteger('duration')->nullable()->comment('actually it"s enum handel by CourseDurationEnum');
            $table->string('status', 20)->default('start')->comment('handel by PersonalPreferencesProcessStatus');
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
