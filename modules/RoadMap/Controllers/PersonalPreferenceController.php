<?php

namespace Modules\RoadMap\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Requests\PersonalPreferenceCreateRequest;
use Modules\RoadMap\Requests\PersonalPreferenceUpdateRequest;
use Modules\RoadMap\Resources\PersonalPreferenceResource;

class PersonalPreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PersonalPreferenceResource::collection(PersonalPreference::belongsToUser(auth()->user())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalPreferenceCreateRequest $request)
    {
        $personalPreference = PersonalPreference::startFor(auth()->user());
        $personalPreference->update($request->validated());
        $personalPreference->updateStatus();

        return PersonalPreferenceResource::make($personalPreference);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalPreference $personalPreference)
    {
        return PersonalPreferenceResource::make($personalPreference);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonalPreferenceUpdateRequest $request, ?PersonalPreference $personalPreference)
    {
        $personalPreference = $request->getPersonalPreference();
        $personalPreference->update($request->validated());
        return PersonalPreferenceResource::make($personalPreference);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalPreference $personalPreference)
    {
        //
    }
}
