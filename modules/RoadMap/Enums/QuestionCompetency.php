<?php

namespace Modules\RoadMap\Enums;

use Filament\Support\Contracts\HasLabel;

enum QuestionCompetency: int implements HasLabel
{
    case PROBLEM_SOLVING_ONE = 11;
    case PROBLEM_SOLVING_TWO = 12;
    case PROBLEM_SOLVING_THREE = 13;
    case PROBLEM_SOLVING_FOUR = 14;
    case PROBLEM_SOLVING_FIVE = 15;


    case LEADER_SHIP_AND_PEPPLE_SKILLS_ONE = 21;
    case LEADER_SHIP_AND_PEPPLE_SKILLS_TWO = 22;
    case LEADER_SHIP_AND_PEPPLE_SKILLS_THREE = 23;
    case LEADER_SHIP_AND_PEPPLE_SKILLS_FOUR = 24;
    case LEADER_SHIP_AND_PEPPLE_SKILLS_FIVE = 25;


    case SELF_MANAGMENT_ONE = 31;
    case SELF_MANAGMENT_TWO = 32;
    case SELF_MANAGMENT_THREE = 33;
    case SELF_MANAGMENT_FOUR = 34;
    case SELF_MANAGMENT_FIVE = 35;


    case AI_AND_TECH_ONE = 41;
    case AI_AND_TECH_TWO = 42;
    case AI_AND_TECH_THREE = 43;
    case AI_AND_TECH_FOUR = 44;
    case AI_AND_TECH_FIVE = 45;

    public static function values(): array
    {
        return [
            self::PROBLEM_SOLVING_ONE->value,
            self::PROBLEM_SOLVING_TWO->value,
            self::PROBLEM_SOLVING_THREE->value,
            self::PROBLEM_SOLVING_FOUR->value,
            self::PROBLEM_SOLVING_FIVE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_ONE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_TWO->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_THREE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_FOUR->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_FIVE->value,
            self::SELF_MANAGMENT_ONE->value,
            self::SELF_MANAGMENT_TWO->value,
            self::SELF_MANAGMENT_THREE->value,
            self::SELF_MANAGMENT_FOUR->value,
            self::SELF_MANAGMENT_FIVE->value,
            self::AI_AND_TECH_ONE->value,
            self::AI_AND_TECH_TWO->value,
            self::AI_AND_TECH_THREE->value,
            self::AI_AND_TECH_FOUR->value,
            self::AI_AND_TECH_FIVE->value,
        ];
    }

    public static function get(?string $name)
    {
        return match ($name) {
            self::PROBLEM_SOLVING_ONE->name =>  self::PROBLEM_SOLVING_ONE->value,
            self::PROBLEM_SOLVING_TWO->name =>  self::PROBLEM_SOLVING_TWO->value,
            self::PROBLEM_SOLVING_THREE->name => self::PROBLEM_SOLVING_THREE->value,
            self::PROBLEM_SOLVING_FOUR->name =>  self::PROBLEM_SOLVING_FOUR->value,
            self::PROBLEM_SOLVING_FIVE->name =>  self::PROBLEM_SOLVING_FIVE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_ONE->name =>  self::LEADER_SHIP_AND_PEPPLE_SKILLS_ONE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_TWO->name =>  self::LEADER_SHIP_AND_PEPPLE_SKILLS_TWO->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_THREE->name => self::LEADER_SHIP_AND_PEPPLE_SKILLS_THREE->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_FOUR->name =>  self::LEADER_SHIP_AND_PEPPLE_SKILLS_FOUR->value,
            self::LEADER_SHIP_AND_PEPPLE_SKILLS_FIVE => self::LEADER_SHIP_AND_PEPPLE_SKILLS_FIVE->value_FIVE->value,
            self::SELF_MANAGMENT_ONE->name =>  self::SELF_MANAGMENT_ONE->value,
            self::SELF_MANAGMENT_TWO->name =>  self::SELF_MANAGMENT_TWO->value,
            self::SELF_MANAGMENT_THREE->name => self::SELF_MANAGMENT_THREE->value,
            self::SELF_MANAGMENT_FOUR->name =>  self::SELF_MANAGMENT_FOUR->value,
            self::SELF_MANAGMENT_FIVE->name => self::SELF_MANAGMENT_FIVE->value,
            self::AI_AND_TECH_ONE->name =>  self::AI_AND_TECH_ONE->value,
            self::AI_AND_TECH_TWO->name =>  self::AI_AND_TECH_TWO->value,
            self::AI_AND_TECH_THREE->name => self::AI_AND_TECH_THREE->value,
            self::AI_AND_TECH_FOUR->name =>  self::AI_AND_TECH_FOUR->value,
            self::AI_AND_TECH_FIVE->value  => self::AI_AND_TECH_FIVE->value,
            default => null,
        };
    }


    public function getLabel(): ?string
    {
        return $this->name;
    }
}
