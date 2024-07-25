<?php

namespace Modules\RoadMap\Controllers;

use Modules\RoadMap\Resources\CareerResource;
use App\Http\Controllers\Controller;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Requests\CourseCreateRequest;

class CourseController extends Controller
{
    public function store(CourseCreateRequest $request)
    {
        Course::findOrFail($request->validated('course_id'))->attachToUser(auth()->user());
        $graphData = [
            'avrage' => [
                "PROBLEM_SOLVING" => 6,
                "LEADER_SHIP_AND_PEPPLE_SKILLS" => 5,
                "SELF_MANAGMENT" => 12,
                "AI_AND_TECH" => 7
            ],
            'now' => [
                "PROBLEM_SOLVING" => 1,
                "LEADER_SHIP_AND_PEPPLE_SKILLS" => 3,
                "SELF_MANAGMENT" => 8,
                "AI_AND_TECH" => 3
            ],
            'future' => [
                "PROBLEM_SOLVING" => 1 + random_int(0, 15 - 1),
                "LEADER_SHIP_AND_PEPPLE_SKILLS" => 3 + random_int(0, 15 - 3),
                "SELF_MANAGMENT" => 8 + random_int(0, 15 - 8),
                "AI_AND_TECH" => 3 + random_int(0, 15 - 3)
            ],
        ];
        return response()->json([
            'message' => 'course added successfully.',
            'graph' => $graphData,
        ]);       
    }
}
