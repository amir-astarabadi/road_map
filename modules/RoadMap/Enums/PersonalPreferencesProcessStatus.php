<?php

namespace Modules\RoadMap\Enums;

enum PersonalPreferencesProcessStatus :string
{
    const START = 'start';

    const BUDGET = 'budget';

    const COURSE_LENGTH = 'course_length';

    const COURSE_LOCATION = 'course_location';

    const INDUSTRIES = 'industries';

    const JOBS = 'jobs';

    const FINISH = 'finish';
}