<?php

namespace Modules\RoadMap\Enums;

enum StudyAbroad: int
{
    case YES = 1;

    case NO = 2;

    case NOT_SURE = 3;


    public static function values(): array
    {
        return [
            self::YES->value,
            self::NO->value,
            self::NOT_SURE->value,
        ];
    }
}
