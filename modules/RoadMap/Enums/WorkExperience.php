<?php

namespace Modules\RoadMap\Enums;

enum WorkExperience: int
{
    case ZERO_TO_TWO = 1;

    case TWO_TO_FIVE = 2;

    case PLUSE_FIVE = 3;

    case CAREER_CHNGER = 4;

    public static function values(): array
    {
        return [
            self::ZERO_TO_TWO->value,
            self::TWO_TO_FIVE->value,
            self::PLUSE_FIVE->value,
            self::CAREER_CHNGER->value,
        ];
    }
}
