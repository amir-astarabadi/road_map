<?php

namespace Modules\RoadMap\Services;

use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Exam;

class Roadmap
{
    public static function make(User $user)
    {
        $exam = static::getTargetExamForRoadmap($user);
        return static::suggest($exam->result);
    }

    private static function getTargetExamForRoadmap(User $user)
    {
        return Exam::whereBelongsTo($user)->first();
    }

    private static function suggest($result)
    {
        // gather course base result
        $suggestions = [];

        foreach (CourseLength::values() as $length) {
            $suggestions[$length] = [
                "books" => [
                    static::fakeBook(),
                    static::fakeBook(),
                ],
                "onlien courses" => [],
                "youtube videos" => [],
                "articles" => [],
            ];
        }

        return $suggestions;
    }

    private static function fakeBook()
    {
        return [
            "id" => random_int(1, 250),
            "title" => fake()->words(random_int(3, 5), true),
            "description" => fake()->realText(random_int(500, 600)),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "authors" => array_filter([
                fake()->firstName() . " " . fake()->lastName(),
                random_int(0, 1) ? fake()->firstName() . " " . fake()->lastName() : null
            ]),
            "publisher" => "John Wiley Sons Inc",
            "Language" => "English",
            "number_of_pages" => random_int(110, 350),
            "skills" => [
                [
                    'title' => QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                    'level' => random_int(1, 5),
                ],
                [
                    'title' => QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                    'level' => random_int(1, 5),
                ],
            ]
        ];
    }
}
