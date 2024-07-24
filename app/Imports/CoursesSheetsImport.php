<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\RoadMap\Models\Course;

class CoursesSheetsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
            new CoursesImport(),
        ];
    }
}
