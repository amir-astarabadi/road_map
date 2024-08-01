<?php

namespace Modules\RoadMap\Services;

use Illuminate\Http\Response;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;

class Roadmap
{
    public static function make(User $user)
    {
        $exam = static::getTargetExamForRoadmap($user);
        return static::suggestBase($exam->result, $user);
    }

    private static function getTargetExamForRoadmap(User $user)
    {
        $exam = $user->latestFinishedExam();
        if (is_null($exam)) {
            abort(Response::HTTP_FORBIDDEN, 'You have no finished exam.');
        }
        return $exam;
    }

    private static function suggestBase($result, User $user)
    {
        $orderdCompetency = self::orderCompetency($result);

        $personalPreference = $user->personalPreference->first();
        $userCourses = $user->courses->pluck('pivot.course_id')->toArray();

        $budget = $personalPreference?->budget['max'] ?? 0;

        $courses = Course::query()
            ->whereNotIn('id', $userCourses)
            ->where(function ($query) use ($budget) {
                $query->where('price', '<=', $budget * 100);
            })
            ->when($personalPreference?->duration, fn ($q) => $q->whereLength($personalPreference->duration))
            ->orderByRaw("FIELD(main_competency,$orderdCompetency)");


        $suggestions = [
            'graph_data' => [
                'avrage' => Exam::avg(),
                'now' => $rightNowStatus = auth()->user()->result,
                'future' => $rightNowStatus,
            ],
            'courses' => [],
        ];


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
                "skills" => $course->skills,
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
                "skills" => $course->skills,
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
                "skills" => $course->skills,
                "url" => $course->url,
                "publisher" => $course->publisher,
            ];
        }
        return $articles;
    }

    private static function orderCompetency($result)
    {
        $result = json_decode(json_encode($result), true)['competency'];

        $r = [];

        foreach ($result as $key => $value) {
            $r[QuestionCompetency::get($key)] = $value;
        }

        asort($r);

        return implode(',', array_filter(array_keys($r)));
    }
}
