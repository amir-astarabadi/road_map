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
        Schema::table('personal_preferences', function (Blueprint $table) {
            $table->unsignedTinyInteger('study_abroad')->nullable()->comment('actually it"s enum handel by StudyAbroadEnum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_preferences', function (Blueprint $table) {
            $table->dropColumn('study_abroad');
        });
    }
};
