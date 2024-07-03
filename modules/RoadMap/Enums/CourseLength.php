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
}
