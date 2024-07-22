<?php

namespace Modules\RoadMap\Enums;

use Filament\Support\Contracts\HasLabel;

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
}
