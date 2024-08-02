<?php

namespace Modules\RoadMap\Enums;

use Filament\Support\Contracts\HasLabel;

enum CourseCategory: int implements HasLabel
{
    case PROBLEM_SOLVING = 1;

    case LEADER_SHIP_AND_PEPPLE_SKILLS = 2;

    case SELF_MANAGMENT = 3;

    case AI_AND_TECH = 4;

    public static function values(): array
    {
        return [
            self::PROBLEM_SOLVING->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS->value,
            self::SELF_MANAGMENT->value,
            self::AI_AND_TECH->value,
        ];
    }

    public static function getName($value)
    {
        return match ($value) {
            self::PROBLEM_SOLVING->value => self::PROBLEM_SOLVING->name,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS->value => self::LEADER_SHIP_AND_PEPPLE_SKILLS->name,
            self::SELF_MANAGMENT->value => self::SELF_MANAGMENT->name,
            self::AI_AND_TECH->value => self::AI_AND_TECH->name,
            default => self::PROBLEM_SOLVING->name,
        };
    }

    public static function get($value)
    {
        return match ($value) {
            self::PROBLEM_SOLVING->name => self::PROBLEM_SOLVING->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS->name => self::LEADER_SHIP_AND_PEPPLE_SKILLS->value,
            self::SELF_MANAGMENT->name => self::SELF_MANAGMENT->value,
            self::AI_AND_TECH->name => self::AI_AND_TECH->value,
            default => self::PROBLEM_SOLVING->value,
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public static function toHuman($string)
    {
        $string = strtolower(implode(' ', explode('_', $string)));
        return ucwords($string);
    }
}
