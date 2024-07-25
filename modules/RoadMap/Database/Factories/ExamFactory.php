<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Exam;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class ExamFactory extends Factory
{

    protected $model = Exam::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'result' =>  []
        ];
    }

    public function forUser(User $user)
    {
        return $this->state([
            'user_id' => $user->getKey()
        ]);
    }

    public function withResult()
    {
        return $this->state([
            'finished_at' => now(),
            'result' => [
                "category" =>  [
                    "PROBLEM_SOLVING" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS" => 0,
                    "SELF_MANAGMENT" => 1,
                    "AI_AND_TECH" => 3,
                ],
                "competency" =>  [
                    "PROBLEM_SOLVING_ONE" => 0,
                    "PROBLEM_SOLVING_TWO" => 0,
                    "PROBLEM_SOLVING_THREE" => 0,
                    "PROBLEM_SOLVING_FOUR" => 0,
                    "PROBLEM_SOLVING_FIVE" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS_ONE" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS_TWO" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS_THREE" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS_FOUR" => 0,
                    "LEADER_SHIP_AND_PEPPLE_SKILLS_FIVE" => 0,
                    "SELF_MANAGMENT_ONE" => 0,
                    "SELF_MANAGMENT_TWO" => 0,
                    "SELF_MANAGMENT_THREE" => 0,
                    "SELF_MANAGMENT_FOUR" => 1,
                    "SELF_MANAGMENT_FIVE" => 0,
                    "AI_AND_TECH_ONE" => 0,
                    "AI_AND_TECH_TWO" => 0,
                    "AI_AND_TECH_THREE" => 0,
                    "AI_AND_TECH_FOUR" => 3,
                    "AI_AND_TECH_FIVE" => 0,
                ]
            ],
        ]);
    }
}
