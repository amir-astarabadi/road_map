<?php

namespace Modules\Authentication\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Authentication\Database\Factories\UserFactory;
use Modules\Authentication\Enums\Sex;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Modules\RoadMap\Enums\CourseCategory;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\PersonalPreference;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasName, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'email',
        'password',
        'birth_date',
        'place_of_residence',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['courses', 'exams'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'sex' => Sex::class
    ];

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    public function getFilamentName(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function latestFinishedExam()
    {
        return $this->exams()->whereNotNull('finished_at')->latest()->first();
    }

    public function getResultAttribute()
    {
        $result = [
            "PROBLEM_SOLVING" => 0,
            "LEADER_SHIP_AND_PEPPLE_SKILLS" => 0,
            "SELF_MANAGMENT" => 0,
            "AI_AND_TECH" => 0
        ];

        $exam = $this->latestFinishedExam();

        if (empty($exam)) return $result;

        return [
            "PROBLEM_SOLVING" => $exam->result?->category?->PROBLEM_SOLVING,
            "LEADER_SHIP_AND_PEPPLE_SKILLS" => $exam->result?->category?->LEADER_SHIP_AND_PEPPLE_SKILLS,
            "SELF_MANAGMENT" => $exam->result?->category?->SELF_MANAGMENT,
            "AI_AND_TECH" => $exam->result?->category?->AI_AND_TECH
        ];
    }

    public function getFutureAttribute()
    {
        $rightNowStatus = $this->result;

        foreach ($this->courses as $course) {
            foreach ($course->skills ?? [] as $courseSkill) {
                foreach ($rightNowStatus as $skill => $score) {
                    if (CourseCategory::get($skill) == $courseSkill) {
                        $rightNowStatus[$skill] = $score < $course->final_level ? $course->final_level : $score;
                    }
                }
            }
        }

        return $rightNowStatus;
    }

    public function personalPreference()
    {
        return $this->hasMany(PersonalPreference::class)->whereStatus(PersonalPreferencesProcessStatus::FINISH)->latest()->limit(1);
    }

    public function hasAddedThisCourse(int $courseId): bool
    {
        return $this->courses()->whereCourseId($courseId)->exists();
    }

    public function getCharechterAttribute()
    {
        $examScores = $this->latestFinishedExam()?->result->category;
        foreach ($examScores as $skill => $score) {
            if ($score <= 5) $score = 'low';
            elseif ($score <= 10) $score = 'medium';
            else $score = 'heigh';
            $examScores->$skill = $score;
        }


        return Character::query()
            ->whereProblemSolving($examScores->PROBLEM_SOLVING)
            ->whereAiAndTech($examScores->AI_AND_TECH)
            ->whereSelfManagment($examScores->SELF_MANAGMENT)
            ->whereLeaderShipAndPeppleSkills($examScores->LEADER_SHIP_AND_PEPPLE_SKILLS)
            ->first() ??
            Character::default();
    }
}
