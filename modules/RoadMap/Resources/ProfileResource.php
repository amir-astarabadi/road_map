<?php

namespace Modules\RoadMap\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\RoadMap\Enums\CourseCategory;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Exam;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rightNowResult = auth()->user()->result;
        $graphData = [
            'avrage' => Exam::avg(),
            'now' => auth()->user()->result,
            'future' => auth()->user()->future,
        ];

        $suggestions = [

            'user' => [
                'id' => $this->resource->id,
                "character" => $this->resource->charechter?->title,
                "character_description" => $this->resource->charechter?->desc,
                "character_statement" => $this->resource->charechter?->statment,
                'profile_image' => $this->resource->charechter?->image_url
            ],
            "courses" => [],
            "graph_data" => $graphData
        ];

        $courses = auth()->user()->courses();

        foreach (CourseLength::values() as $length) {
            $base = clone $courses;
            $base->whereLength($length);
            $books = clone $base;
            $videos = clone $base;
            $articles = clone $base;

            $books = static::makeBooks($books->where('type', '=', CourseType::Book->value)->get());
            $videos = static::makeVideos($videos->where('type', '=', CourseType::Video->value)->get());
            $articles = static::makeArticles($articles->where('type', '=', CourseType::Article->value)->get());

            if ($books) $suggestions['courses'][$length]['books'] = $books;
            if ($videos) $suggestions['courses'][$length]['online courses'] = $videos;
            if ($articles) $suggestions['courses'][$length]['articles'] = $articles;
        }

        return $suggestions;
    }


    private static function makeBooks($courses)
    {
        $books = [];
        foreach ($courses as $course) {
            $books[] = [
                "id" => $course->id,
                "title" => $course->title,
                "description" => $course->description,
                "price" => $course->price,
                "picture" => $course->image_url,
                "authors" => $course->instructors,
                "publisher" => $course->publisher,
                "Language" => $course->language,
                "number_of_pages" => $course->number_of_pages,
                "level" => $course->level_name,
                "skills" => $course->only_skills_name,
                "url" => $course->url,
            ];
        }

        return $books;
    }

    private static function makeVideos($courses)
    {
        $videos = [];
        foreach ($courses as $course) {
            $videos[] = [
                "id" => $course->id,
                "title" => $course->title,
                "description" => $course->description,
                "price" => $course->price,
                "picture" => $course->image_url,
                "channel" => $course->channel,
                "level" => $course->level_name,
                "skills" => $course->only_skills_name,
                "url" => $course->url,
                'duration' => $course->duration
            ];
        }
        return $videos;
    }

    private static function makeArticles($courses)
    {
        $articles = [];
        foreach ($courses as $course) {
            $articles[] = [
                "id" => $course->id,
                "title" => $course->title,
                "description" => $course->description,
                "price" => $course->price,
                "picture" => $course->image_url,
                "level" => $course->level_name,
                "skills" => $course->only_skills_name,
                "url" => $course->url,
                "publisher" => $course->publisher,
            ];
        }
        return $articles;
    }
}
