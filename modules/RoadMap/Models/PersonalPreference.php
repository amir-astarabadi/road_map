<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\PersonalPreferenceFactory;
use Modules\RoadMap\Enums\CourseFormat;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\Duration;
use Modules\RoadMap\Enums\NeedDegree;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;
use Modules\RoadMap\Enums\WorkExperience;

class PersonalPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'career_id',
        'budget',
        'work_experience',
        'course_format',
        'need_degree',
        'duration',
        'status',
    ];

    protected $cases = [
        'work_experience' => WorkExperience::class,
        'course_format' => CourseFormat::class,
        'need_degree' => NeedDegree::class,
        'duration' => Duration::class,
        'status' => PersonalPreferencesProcessStatus::class,
    ];

    protected static function newFactory()
    {
        return new PersonalPreferenceFactory();
    }

    public function budget(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }

    public function getWorkExperienceAttribute()
    {
        return WorkExperience::get($this->getRawOriginal('work_experience'));
    }

    public function getCourseFormatAttribute()
    {
        return CourseFormat::get($this->getRawOriginal('course_format'));
    }

    public function getDurationAttribute()
    {
        return CourseLength::get($this->getRawOriginal('duration'));
    }

    public function industries(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function scopeBelongsToUser(Builder $query, User $user): Builder
    {
        return $query->whereUserId($user->getKey());
    }

    public function scopeIsOpen(Builder $query): Builder
    {
        return $query->where('status', '!=', PersonalPreferencesProcessStatus::FINISH);
    }

    public static function startFor(User $user): static
    {
        return static::create([
            'user_id' => $user->getKey(),
            'status' => PersonalPreferencesProcessStatus::START
        ]);
    }

    public function isOnStatus(string|array $status): bool
    {
        if (is_array($status)) {
            return in_array($this->status, $status);
        }

        return $this->status === $status;
    }

    public static function getOrMakeAnOngoing()
    {
        return static::belongsToUser(auth()->user())->isOpen()->first() ??
            static::create([
                'user_id' => auth()->id(),
                'status' => PersonalPreferencesProcessStatus::START
            ]);
    }

    public function updateStatus()
    {
        dd(
            '  filled($this->career_id)',
            filled($this->career_id),
            '  filled($this->budget)',
            filled($this->budget),
            '  filled($this->work_experience)',
            filled($this->work_experience),
            '  filled($this->course_format)',
            filled($this->course_format),
            '  filled($this->need_degree)',
            filled($this->need_degree),
            '  filled($this->duration)',
            filled($this->duration)
        );
        if (
            filled($this->career_id) &&
            filled($this->budget) &&
            filled($this->work_experience) &&
            filled($this->course_format) &&
            filled($this->need_degree) &&
            filled($this->duration)
        ) {
            $this->status = PersonalPreferencesProcessStatus::FINISH;
            return;
        }
        if (filled($this->career_id)) {
            $this->status = PersonalPreferencesProcessStatus::BUDGET;
        } else {
            $this->status = PersonalPreferencesProcessStatus::CAREER;
            return;
        }

        if (filled($this->budget)) {
            $this->status = PersonalPreferencesProcessStatus::WORK_EXPERIENCE;
        } else {
            $this->status = PersonalPreferencesProcessStatus::BUDGET;
            return;
        }

        if (filled($this->work_experience)) {
            $this->status = PersonalPreferencesProcessStatus::COURSE_FORMAT;
        } else {
            $this->status = PersonalPreferencesProcessStatus::WORK_EXPERIENCE;
            return;
        }
        if (filled($this->course_format)) {
            $this->status = PersonalPreferencesProcessStatus::DEGREE;
        } else {
            $this->status = PersonalPreferencesProcessStatus::COURSE_FORMAT;
            return;
        }

        if (filled($this->need_degree)) {
            $this->status = PersonalPreferencesProcessStatus::DURATION;
        } else {
            $this->status = PersonalPreferencesProcessStatus::DEGREE;
            return;
        }

        if (filled($this->duration)) {
            $this->status = PersonalPreferencesProcessStatus::FINISH;
            return;
        } else {
            $this->status = PersonalPreferencesProcessStatus::DURATION;
            return;
        }

        $this->status = PersonalPreferencesProcessStatus::DURATION;
    }
}
