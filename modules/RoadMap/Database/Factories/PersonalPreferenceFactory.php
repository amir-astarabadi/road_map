<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseFormat;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\NeedDegree;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus as Status;
use Modules\RoadMap\Enums\WorkExperience;
use Modules\RoadMap\Models\Career;
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
            'career_id' => Career::factory(),
            'budget' => null,
            'work_experience' => null,
            'course_format' => null,
            'need_degree' => null,
            'duration' => null,
            'status' => Status::START,
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(['user_id' => $user->getKey()]);
    }

    public function inStatus(string $status)
    {
        $inputs = [
            'career_id' => !in_array($status, [Status::START->value])  ? Career::factory()->create()->getKey() : null,
            'budget' => !in_array($status, [Status::START->value, Status::CAREER->value]) ? ['min' => 10, 'max' => 1000] : null,
            'work_experience' => !in_array($status, [Status::START->value, Status::CAREER->value, Status::BUDGET->value])  ? WorkExperience::ZERO_TO_TWO : null,
            'course_format' => !in_array($status, [Status::START->value, Status::CAREER->value, Status::BUDGET->value, Status::WORK_EXPERIENCE->value]) ? CourseFormat::ONLINE->value : null,
            'need_degree' => !in_array($status, [Status::START->value, Status::CAREER->value, Status::BUDGET->value, Status::WORK_EXPERIENCE->value, Status::COURSE_FORMAT->value]) ? NeedDegree::YES->value : null,
            'status' => $status,
        ];
        return $this->state($inputs);
    }
}
