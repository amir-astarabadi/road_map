<?php

namespace Modules\RoadMap\Controllers;

use App\Http\Controllers\Controller;
use Modules\RoadMap\Resources\ProfileResource;

class ProfileContoller extends Controller
{

    public function show()
    {
        return ProfileResource::make(auth()->user());
    }
}
