<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\RoadMap\Enums\CourseType;

class CoursesSheetsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CoursesImport(CourseType::Book),
            new CoursesImport(CourseType::Book),
            new CoursesImport(CourseType::Book),
            new CoursesImport(CourseType::Book),
            new CoursesImport(CourseType::Video),
            new CoursesImport(CourseType::Video),
            new CoursesImport(CourseType::Video),
            new CoursesImport(CourseType::Video),
            new CoursesImport(CourseType::Article),
            new CoursesImport(CourseType::Article),
            new CoursesImport(CourseType::Article),
            new CoursesImport(CourseType::Article),

        ];
    }
}
