<?php

namespace Modules\RoadMap\Controllers;

use Modules\RoadMap\Resources\CareerResource;
use App\Http\Controllers\Controller;
use Modules\RoadMap\Models\Career;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CareerResource::collection(Career::all());
    }
}
