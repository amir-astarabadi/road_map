<?php

namespace Modules\RoadMap\Observers;

use Modules\RoadMap\Models\PersonalPreference;

class PersonalPreferenceObserver
{
    public function updating(PersonalPreference $personalPreference)
    {
        $personalPreference->updateStatus();
    }
}
