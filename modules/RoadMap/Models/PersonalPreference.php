<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\PersonalPreferenceFactory;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;

class PersonalPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'budget',
        'course_length_type',
        'course_location_type',
        'industries',
        'jobs',
        'status',
    ];

    protected $cases = [
        'course_length' => CourseLength::class,
        'course_location_type' => CourseLocation::class,
        'status' => PersonalPreferencesProcessStatus::class,
    ];

    protected static function newFactory()
    {
        return new PersonalPreferenceFactory();
    }

    public function jobs(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }



    public function industries(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function scopeBlongToUser(Builder $query, User $user): Builder
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
        if(is_array($status)){
            return in_array($this->status, $status);
        }
        
        return $this->status === $status;
    }

    public function updateStatus()
    {
        // from last status related field check and update status
        if (!is_null($this->jobs)) {
            return $this->status = PersonalPreferencesProcessStatus::FINISH;
        }
        if (!is_null($this->industries)) {
            return $this->status = PersonalPreferencesProcessStatus::JOBS;
        }
        if (!is_null($this->course_location_type)) {
            return $this->status = PersonalPreferencesProcessStatus::INDUSTRIES;
        }
        if (!is_null($this->course_length_type)) {
            return $this->status = PersonalPreferencesProcessStatus::COURSE_LOCATION;
        }
        if (!is_null($this->budget)) {
            return $this->status = PersonalPreferencesProcessStatus::COURSE_LENGTH;
        }

        // if none of last conditions became trun it means its first update and first item right now is budget
        return $this->status = PersonalPreferencesProcessStatus::BUDGET;
    }
}
