<?php

namespace Modules\RoadMap\Enums;

use Filament\Support\Contracts\HasLabel;

use function Laravel\Prompts\select;

enum CourseLevel: int implements HasLabel
{
    case Low = 1;

    case Medium = 2;
    
    case High = 3;

    case Advanced = 4;

    public static function values(): array
    {
        return [
            self::Low->value,
            self::Medium->value,
            self::High->value,
            self::Advanced->value,
        ];
    }

    public function getLabel(): ?string
    {
        return $this->name;
        
    }

    public static function get(string $name)
    {
        return match($name){
            self::Low->name => self::Low->value, 
            self::Medium->name => self::Medium->value, 
            self::High->name => self::High->value, 
            self::Advanced->name => self::Advanced->value, 
            default => 1,
        };
    }

    public static function getName(?int $value)
    {
        return match($value){
            self::Low->value => self::Low->name, 
            self::Medium->value => self::Medium->name, 
            self::High->value => self::High->name, 
            self::Advanced->value => self::Advanced->name, 
            default => self::Low->name,
        };
    }
}
