<?php

namespace Modules\RoadMap\Enums;

enum CourseLocation :string
{
    const ONLINE = 'online';

    const OFFLINE = 'offline';
    
    const HYBRIDE = 'hybride';


    public static function values(): array
    {
        return [
            self::ONLINE,
            self::OFFLINE,
            self::HYBRIDE,
        ];
    }
}