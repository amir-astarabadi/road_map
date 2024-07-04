<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;
use Modules\RoadMap\Models\PersonalPreference;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class PersonalPreferenceFactory extends Factory
{

    protected $model = PersonalPreference::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'budget' => null,
            'course_length_type' => null,
            'course_location_type' => null,
            'industries' => null,
            'jobs' => null,
            'status' => PersonalPreferencesProcessStatus::START,
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(['user_id' => $user->getKey()]);
    }

    public function inStatus(string $status)
    {
        $inputs = [
            'budget' => !in_array($status, [PersonalPreferencesProcessStatus::START])  ? 150 : null,
            'course_length_type' => !in_array($status, [PersonalPreferencesProcessStatus::START, PersonalPreferencesProcessStatus::BUDGET])  ? CourseLength::LONG_TERM : null,
            'course_location_type' => !in_array($status, [PersonalPreferencesProcessStatus::START, PersonalPreferencesProcessStatus::BUDGET, PersonalPreferencesProcessStatus::COURSE_LENGTH]) ? CourseLocation::ONLINE : null,
            'industries' => !in_array($status, [PersonalPreferencesProcessStatus::START, PersonalPreferencesProcessStatus::BUDGET, PersonalPreferencesProcessStatus::COURSE_LENGTH,PersonalPreferencesProcessStatus::COURSE_LOCATION ]) ? ['i1, i2'] : null,
            'jobs' => !in_array($status, [PersonalPreferencesProcessStatus::START, PersonalPreferencesProcessStatus::BUDGET, PersonalPreferencesProcessStatus::COURSE_LENGTH,PersonalPreferencesProcessStatus::COURSE_LOCATION, PersonalPreferencesProcessStatus::INDUSTRIES ]) ? ['j1, j2'] : null,
            'status' => $status,
        ];
        return $this->state($inputs);
    }
}
