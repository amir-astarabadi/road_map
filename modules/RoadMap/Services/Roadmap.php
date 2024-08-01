<?php

namespace Modules\RoadMap\Services;

use Illuminate\Http\Response;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;

class Roadmap
{
    public static function make(User $user)
    {
        $exam = static::getTargetExamForRoadmap($user);
        return static::suggestBase($exam->result);
    }

    private static function getTargetExamForRoadmap(User $user)
    {
        $exam = $user->latestFinishedExam();
        if (is_null($exam)) {
            abort(Response::HTTP_FORBIDDEN, 'You have no finished exam.');
        }
        return $exam;
    }

    private static function suggestBase($result)
    {
        // gather course base result
        $suggestions = [
            'graph_data' => [
                'avrage' => Exam::avg(),
                'now' => $rightNowStatus = auth()->user()->result,
                'future' => $rightNowStatus,
            ]
        ];


        foreach (CourseLength::values() as $length) {
            $suggestions['courses'][$length] = [
                "books" => [
                    static::fakeBook(),
                    static::fakeBook(),
                ],
                "online courses" => [
                    static::fakeOnlineCourses(),
                    static::fakeOnlineCourses(),
                ],
                "youtube videos" => [
                    static::fakeOnlineCourses(),
                    static::fakeOnlineCourses(),
                ],
                "articles" => [
                    static::fakeArticles(),
                    static::fakeArticles(),
                ],
            ];
        }

        return $suggestions;
    }

    private static function fakeBook()
    {
        return [
            "id" => Course::query()->inRandomOrder()->first()?->id,
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
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
        ];
    }

    private static function fakeOnlineCourses()
    {

        return [
            "id" => Course::query()->inRandomOrder()->first()?->id,
            "title" => fake()->words(random_int(3, 5), true),
            "description" => fake()->realText(random_int(500, 600)),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "channel" => ['TEDx Talks', 'Mindvalley Talks', 'TED-Ed'][random_int(0, 2)],
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
            'url' => 'https://www.youtube.com/watch?v=R5d-hN9UtpU',
            'duration' => random_int(1, 3600)
        ];
    }

    private static function fakeYoutubeVideos()
    {
        return [
            "id" => Course::query()->inRandomOrder()->first()?->id,
            "title" => fake()->words(random_int(3, 5), true),
            "description" => fake()->realText(random_int(500, 600)),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "channel" => ['TEDx Talks', 'Mindvalley Talks', 'TED-Ed'][random_int(0, 2)],
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
            'url' => 'https://www.youtube.com/watch?v=R5d-hN9UtpU',
            'duration' => random_int(1, 3600)
        ];
    }

    private static function fakeArticles()
    {
        return [
            "id" => Course::query()->inRandomOrder()->first()?->id,
            "title" => fake()->words(random_int(3, 5), true),
            "description" => fake()->realText(random_int(500, 600)),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "authors" => array_filter([
                fake()->firstName() . " " . fake()->lastName(),
                random_int(0, 1) ? fake()->firstName() . " " . fake()->lastName() : null
            ]),
            "publication" => "John Wiley Sons Inc",
            "URL" => 'https://www.science.org/doi/abs/10.1126/science.1169588',
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
        ];
    }
}
