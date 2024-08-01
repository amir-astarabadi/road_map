<?php

namespace App\Console\Commands;

use App\Imports\CoursesImport;
use App\Imports\CoursesSheetsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Modules\RoadMap\Models\Course;

class ImportCoursesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Courses From xlxx';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new CoursesSheetsImport(), storage_path('/app/public/xlsx/courses.xlsx'));
    }
}
