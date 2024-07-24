<?php

namespace Modules\RoadMap\Enums;

use Filament\Support\Contracts\HasLabel;

enum CourseType: int implements HasLabel
{
    case Book = 1;

    case Video = 2;
    
    case Article = 3;


    public static function values(): array
    {
        return [
            self::Book->value,
            self::Video->value,
            self::Article->value,
        ];
    }

    public function getLabel(): ?string
    {
        return $this->name;
        
    }
}
