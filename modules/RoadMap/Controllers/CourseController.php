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
        if (auth()->user()->hasAddedThisCourse($request->get('course_id'))) {
            return response()->json([
                'message' => 'This course has been added to your profile.',
                'graph' => [
                    'avrage' => Exam::avg(),
                    'now' => auth()->user()->result,
                    'future' => auth()->user()->future,
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        $cours = Course::findOrFail($request->validated('course_id'));
        $cours->attachToUser(auth()->user());

        return response()->json([
            'message' => 'course added successfully.',
            'graph' => [
                'avrage' => Exam::avg(),
                'now' => auth()->user()->result,
                'future' => auth()->user()->future,
            ],
        ]);
    }
}
