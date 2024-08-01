<?php

namespace App\Imports;

use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Models\Competency;
use Modules\RoadMap\Models\Course;

class CoursesImport implements ToModel
{
    private static $counter = 0;

    private $type;

    private $method;

    public function __construct(private $courseTyp)
    {
        $this->type = $courseTyp->value;
        $this->method = $courseTyp->name;
    }

    public function model(array $row)
    {
        $data = $this->parseData($row);

        if (empty($data)) {
            return;
        }

        return new Course($data);
    }

    private function parseData(array $row)
    {
        $row = array_filter($row);

        if (empty($row)) {
            return [];
        }

        if (empty($this->type) || empty($this->method)) {
            return [];
        }

        return $this->{$this->method}($row);
    }


    private function Book(array $row)
    {
        if ($row[0] === 'Title' || $row[0] === 'itle' || count($row) < 2) {
            return [];
        }

        try {

            $levelUp = explode('to', $row[5]);
            if (count($levelUp) < 2) {
                return [];
            }

            $data = [
                'title' => $row[0],
                'instructors' => $row[1],
                'main_competency' => Competency::firstOrCreate(['name' => $row[2]])->getKey(),
                'bonus_competencies' => [Competency::firstOrCreate(['name' => $row[3]])->getKey()],
                'level' => CourseLevel::get($row[4]),
                'level_up_from' => CourseLevel::get(trim($levelUp[0])),
                'level_up_to' => CourseLevel::get(trim($levelUp[1])),
                'language' => $row[6],
                'publisher' => $row[7],
                'number_of_pages' => $row[8],
                'description' => $row[9],
                'skills' => null,
                'price' => $row[11] * 100, // convert to cent
                'url' => $row[14],
                'channel' => null,
                'duration' => null,
                'length' => CourseLength::SHORT_TERM,
                'type' => $this->type,
                'cover' => null,
            ];
        } catch (Exception $e) {
            return [];
        }
        return $data;
    }

    private function Video(array $row)
    {
        if (($row[0] === 'Title' || $row[0] === 'itle') || count($row) < 2) {
            return [];
        }

        $levelUp = explode('to', $row[5]);

        return [
            'title' => $row[0],
            'channel' => $row[1],
            'main_competency' => Competency::firstOrCreate(['name' => $row[2]])->getKey(),
            'bonus_competencies' => [Competency::firstOrCreate(['name' => $row[3]])->getKey()],
            'level' => CourseLevel::get($row[4]),
            'level_up_from' => CourseLevel::get(trim($levelUp[0])),
            'level_up_to' => CourseLevel::get(trim($levelUp[1])),
            'duration' => 0,
            'length' => CourseLength::SHORT_TERM,
            'description' => $row[7],
            'url' => $row[8],
            'price' => 0,
            'skills' => null,
            'number_of_pages' => 0,
            'type' => $this->type,
            'instructors' => null,
            'cover' => null,
        ];
    }

    private function Article(array $row)
    {

        if (($row[0] === 'Title' || $row[0] === 'itle') || count($row) < 2) {
            return [];
        }

        $levelUp = explode('to', $row[5]);

        return [
            'title' => $row[0],
            'instructors' => $row[1],
            'main_competency' => Competency::firstOrCreate(['name' => $row[2]])->getKey(),
            'bonus_competencies' => [Competency::firstOrCreate(['name' => $row[3]])->getKey()],
            'level' => CourseLevel::get($row[4]),
            'level_up_from' => CourseLevel::get(trim($levelUp[0])),
            'level_up_to' => CourseLevel::get(trim($levelUp[1])),
            'description' => $row[6],
            'publisher' => $row[7],
            'url' => $row[8],
            'price' => 0,
            'skills' => null,
            'channel' => null,
            'number_of_pages' => 0,
            'duration' => 0,
            'length' => CourseLength::SHORT_TERM,
            'type' => $this->type,
            'cover' => null,
        ];
    }
}
