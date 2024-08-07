<?php

namespace Modules\Authentication\Enums;

enum Sex: int
{
    case MALE = 1;
    case FEMALE = 2;
    case UN_KNOWN = 3;

    public static function values(): array
    {
        return [
            self::MALE->value,
            self::FEMALE->value,
            self::UN_KNOWN->value,
        ];
    }
}
