<?php

namespace Modules\RoadMap\Enums;

enum Duration: int
{
    case LESS_THAN_3_MOUNTH = 1;

    case LESS_THAN_6_MOUNTH = 2;

    case MORE_THAN_6_MOUNTH = 3;

    public static function values(): array
    {
        return [
            self::LESS_THAN_3_MOUNTH->value,
            self::LESS_THAN_6_MOUNTH->value,
            self::MORE_THAN_6_MOUNTH->value,
        ];
    }
}