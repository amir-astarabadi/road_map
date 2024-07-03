<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Models\User;
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
        return $this->state([
            'status' => $status
        ]);
    }
}
