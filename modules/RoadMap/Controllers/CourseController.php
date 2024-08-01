<?php

namespace Modules\RoadMap\Controllers;

use Modules\RoadMap\Resources\CareerResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Requests\CourseCreateRequest;

class CourseController extends Controller
{
    public function store(CourseCreateRequest $request)
    {

        $cours = Course::findOrFail($request->validated('course_id'));
        $avg = Exam::avg();
        $graphData = [
            'avrage' => $avg,
            'now' => $rightNowStatus = auth()->user()->result,
            'future' => $cours->move($rightNowStatus),
        ];

        if (!auth()->user()->hasNotAddedThisCourse($request->get('course_id'))) {
            return response()->json([
                'message' => 'This course has been added to your profile.',
                'graph' => $graphData,
            ], Response::HTTP_FORBIDDEN);
        }
        $cours->attachToUser(auth()->user());

        return response()->json([
            'message' => 'course added successfully.',
            'graph' => $graphData,
        ]);
    }
}
