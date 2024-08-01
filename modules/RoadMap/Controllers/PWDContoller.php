<?php

namespace Modules\RoadMap\Controllers;

use App\Http\Controllers\Controller;
use Modules\RoadMap\Resources\ProfileResource;

class PWDContoller extends Controller
{

    public function __invoke()
    {
        if (auth()->user()->latestFinishedExam()) {
            return response()->json([
                'finshed_state' => 'exam',
                'next_state' => 'sugesstions',
            ]);
        }

        if (auth()->user()->personalPreference->first()) {
            return response()->json([
                'finshed_state' => 'personal_preferences',
                'next_state' => 'exam',
            ]);
        }

        return response()->json([
            'finshed_state' => '',
            'next_state' => 'personal_preferences',
        ]);
    }
}
