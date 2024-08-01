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

    public static function get(?int $value)
    {
        return match($value){
            self::ZERO_TO_TWO->value => self::ZERO_TO_TWO,
            self::TWO_TO_FIVE->value => self::TWO_TO_FIVE,
            self::PLUSE_FIVE->value => self::PLUSE_FIVE,
            self::CAREER_CHNGER->value => self::CAREER_CHNGER,
            default => null
        };
    }
}
