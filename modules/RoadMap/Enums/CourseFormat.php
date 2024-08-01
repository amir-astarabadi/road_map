<?php

namespace Modules\RoadMap\Enums;

enum CourseFormat: int
{
    case ONLINE = 1;

    case IN_PERSON = 2;

    case HYBRIDE = 3;

    public static function values(): array
    {
        return [
            self::ONLINE->value,
            self::IN_PERSON->value,
            self::HYBRIDE->value,
        ];
    }

    public static function get(?int $value)
    {
        return match($value){
            self::ONLINE->value => self::ONLINE,
            self::IN_PERSON->value => self::IN_PERSON,
            self::HYBRIDE->value => self::HYBRIDE,
            default => null
        };
    }
}
