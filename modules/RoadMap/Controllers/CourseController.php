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
        return response()->json(['message' => 'course added successfully.']);       
    }
}
