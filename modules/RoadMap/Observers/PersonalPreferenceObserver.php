<?php

namespace Modules\RoadMap\Observers;

use Modules\RoadMap\Models\PersonalPreference;

class PersonalPreferenceObserver
{
    public function updated(PersonalPreference $personalPreference)
    {
        $personalPreference->updateStatus();
        $personalPreference->save();
    }
}
