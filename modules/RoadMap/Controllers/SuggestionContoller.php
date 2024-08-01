<?php

namespace Modules\RoadMap\Controllers;

use App\Http\Controllers\Controller;
use Modules\RoadMap\Services\Roadmap;

class SuggestionContoller extends Controller
{

    public function show()
    {
        return Roadmap::make(auth()->user());
    }
}
