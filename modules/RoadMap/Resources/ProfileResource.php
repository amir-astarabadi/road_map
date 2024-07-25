<?php

namespace Modules\RoadMap\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\QuestionCategory;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $suggestions = [
            'user' => [
                'id' => $this->resource->id,
                "character" => 'problem solver',
                'profile_iamge' => asset('storage/images/default_profile.png')
            ],
            "courses" => [],
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
            "id" => random_int(1, 250),
            "title" => fake()->words(random_int(3, 5), true),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            'url' => 'https://www.amazon.com/Hillbilly-Elegy-Memoir-Family-Culture/dp/0062300555/ref=zg_d_sccl_2/141-0120825-2305067?pd_rd_w=aALGw&content-id=amzn1.sym.193afb92-0c19-4833-86f8-850b5ba40291&pf_rd_p=193afb92-0c19-4833-86f8-850b5ba40291&pf_rd_r=6AWR4Q640N67MY00B0P9&pd_rd_wg=fKWRI&pd_rd_r=143abdce-6000-40de-9b6b-ee714a37d140&pd_rd_i=0062300555&psc=1',
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
        ];
    }

    private static function fakeOnlineCourses()
    {

        return [
            "id" => random_int(1, 250),
            "title" => fake()->words(random_int(3, 5), true),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            'url' => 'https://www.youtube.com/watch?v=R5d-hN9UtpU',
        ];
    }

    private static function fakeYoutubeVideos()
    {
        return [
            "id" => random_int(1, 250),
            "title" => fake()->words(random_int(3, 5), true),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
            'url' => 'https://www.youtube.com/watch?v=R5d-hN9UtpU',
        ];
    }

    private static function fakeArticles()
    {
        return [
            "id" => random_int(1, 250),
            "title" => fake()->words(random_int(3, 5), true),
            "price" => random_int(0, 10),
            "picture" => asset('storage/images/temp.png'),
            "url" => 'https://www.science.org/doi/abs/10.1126/science.1169588',
            "level" => CourseLevel::cases()[random_int(0, count(CourseLevel::cases()) - 1)],
            "skills" => [
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
                QuestionCategory::cases()[random_int(0, count(QuestionCategory::cases()) - 1)]->name,
            ],
        ];
    }
}
