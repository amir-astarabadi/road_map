<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\RoadMap\Models\Course;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description')->fulltext();
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('level')->comment('actually it"s enum handel by CourseLevelEnum');
            $table->unsignedTinyInteger('level_up_from')->comment('actually it"s enum handel by CourseLevelEnum');
            $table->unsignedTinyInteger('level_up_to')->comment('actually it"s enum handel by CourseLevelEnum');
            $table->string('url');
            $table->morphs('courseable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
        
    }
};
