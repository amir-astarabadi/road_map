<?php

namespace Modules\RoadMap\Enums;

enum CourseLength: string
{
    const SHORT_TERM = 'short';

    const LONG_TERM = 'long';

    public static function values(): array
    {
        return [
            self::SHORT_TERM,
            self::LONG_TERM,
        ];
    }


    public static function get(?int $value)
    {
        return match ($value) {
            Duration::LESS_THAN_3_MOUNTH->value => self::SHORT_TERM,
            default => self::SHORT_TERM
        };
    }
}
