<?php

namespace Modules\RoadMap\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Requests\AnswershitUpdateRequest;
use Modules\RoadMap\Requests\PersonalPreferenceUpdateRequest;
use Modules\RoadMap\Resources\ExamResource;
use Modules\RoadMap\Resources\PersonalPreferenceResource;

class ExamController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exam = Exam::startFor(auth()->user());
        
        return ExamResource::make($exam);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(AnswershitUpdateRequest $request, Exam $exam)
    {
        $exam->storeAnswershit($request->validated('answershit'));
        $exam->updateResult();
        
        return response(['data' => $exam->result]);
    }
}
