<?php

namespace Modules\RoadMap\Enums;

enum PersonalPreferencesProcessStatus :string
{
    case START = 'start';

    case CAREER = 'career';
    
    case BUDGET = 'budget';

    case WORK_EXPERIENCE = 'work_experience';

    case COURSE_FORMAT = 'course_format';
    
    case DEGREE = 'degree';

    case DURATION = 'duration';

    case FINISH = 'finish';
}