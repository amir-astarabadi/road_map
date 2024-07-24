<?php

namespace App\Imports;

use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;
use Modules\RoadMap\Models\Course;

class CoursesImport implements ToModel
{
    private static $counter = 0;
    private static $type = '';
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
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

        $this->setType($row);

        if (empty(static::$type)) {
            return [];
        }

        return $this->{static::$type}($row);
    }

    private function setType(array $row)
    {
        if (($row[0] === 'Title' || $row[0] === 'itle') && $row[8] === 'Number of Pages') {
            static::$type = CourseType::Book->name;
            return;
        }

        if (($row[0] === 'Title' || $row[0] === 'itle') && $row[1] === 'Channel') {
            static::$type = CourseType::Video->name;
            return;
        }

        if (($row[0] === 'Title' || $row[0] === 'itle') && $row[7] === 'Publication') {
            static::$type = CourseType::Article->name;
            return;
        }
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
                'description' => $row[9],
                'level' => CourseLevel::get($row[4]),
                'instructors' => $row[1],
                'level_up_from' => CourseLevel::get(trim($levelUp[0])),
                'level_up_to' => CourseLevel::get(trim($levelUp[1])),
                'url' => $row[14],
                'price' => $row[12] * 100,
                'skills' => null,
                'channel' => null,
                'number_of_pages' => $row[8],
                'duration' => null,
                'type' => CourseType::Book->value,
                'cover' => null,
            ];
        } catch (Exception $e) {
            dump($row);
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
        if (count($levelUp) < 2) {
            dd($row);
        }
//         $duration = array_reverse(explode(':', $row[6]));
//         $d = 0;
//         $p = 1;
// dd($duration, $row, $row[6]);
//         foreach ($duration as $item) {
//             dd($item);
//             $d += ($item * $p);
//             $p *= 60;
//         }
        try{

            $duration = (int)($row[6] * 100);
        }catch(Exception $e){
            $duration = 0;
        }
        return [
            'title' => $row[0],
            'description' => $row[7],
            'instructors' => null,
            'level' => CourseLevel::get($row[4]),
            'level_up_from' => CourseLevel::get(trim($levelUp[0])),
            'level_up_to' => CourseLevel::get(trim($levelUp[1])),
            'url' => $row[8],
            'price' => 0,
            'skills' => null,
            'channel' => $row[1],
            'number_of_pages' => 0,
            'duration' => $duration,
            'type' => CourseType::Video->value,
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
            'description' => $row[6],
            'instructors' => $row[1],
            'level' => CourseLevel::get($row[4]),
            'level_up_from' => CourseLevel::get(trim($levelUp[0])),
            'level_up_to' => CourseLevel::get(trim($levelUp[1])),
            'url' => $row[8],
            'price' => 0,
            'skills' => null,
            'channel' => null,
            'number_of_pages' => 0,
            'duration' => 0,
            'type' => CourseType::Article->value,
            'cover' => null,
        ];
    }
}
