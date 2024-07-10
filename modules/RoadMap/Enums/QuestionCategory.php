<?php

namespace Modules\RoadMap\Enums;

enum QuestionCategory: int
{
    case PROBLEM_SOLVING = 1;

    case LEADER_SHIP_AND_PEPPLE_SKILLS = 2;
    
    case SELF_MANAGMENT = 3;

    case AI_AND_TECH = 4;

    public static function values(): array
    {
        return [
            self::PROBLEM_SOLVING->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS->value,
            self::SELF_MANAGMENT->value,
            self::AI_AND_TECH->value,
        ];
    }
}
