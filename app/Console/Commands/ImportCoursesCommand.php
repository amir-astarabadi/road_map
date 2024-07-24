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
    protected $signature = 'roadmap:import-courses-command';

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

        // Course::create([
        //     "title" => "The Art of Problem Solving",
        //     "description" => "Russell Ackoff",
        //     "level" => 4,
        //     "instructors" => "Explores various problem-solving methodologies and offers practical techniques for complex problems.",
        //     "level_up_from" => 1,
        //     "level_up_to" => 2,
        //     "url" => "Amazon",
        //     "price" => 4.4,
        //     "skills" => null,
        //     "channel" => null,
        //     "number_of_pages" => 408.0,
        //     "duration" => null,
        //     "type" => 1,
        //     "cover" => null,
        // ]);
        Excel::import(new CoursesSheetsImport(), storage_path('/app/public/xlsx/courses.xlsx'));
    }
}
