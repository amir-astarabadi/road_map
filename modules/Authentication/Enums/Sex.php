<?php

namespace Modules\Authentication\Enums;

enum Sex: int
{
    case MALE = 1;
    case FEMALE = 2;

    public static function values(): array
    {
        return [
            self::MALE->value,
            self::FEMALE->value,
        ];
    }
}
