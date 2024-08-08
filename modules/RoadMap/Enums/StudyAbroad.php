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

    public static function get(?int $value)
    {
        return match ($value) {
            self::YES->value => self::YES->name,
            self::NO->value => self::NO->name,
            self::NOT_SURE->value => self::NOT_SURE->name,
            default => self::NOT_SURE->name
        };
    }
}
