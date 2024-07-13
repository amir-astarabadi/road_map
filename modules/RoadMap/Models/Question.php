<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\CareerFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\RoadMap\Database\Factories\QuestionFactory;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'competency',
    ];

    protected $casts = [
        'category' => QuestionCategory::class,
        'competency' => QuestionCompetency::class
    ];

    protected static function newFactory()
    {
        return new QuestionFactory();
    }

    public function getCategoryEnumAttribute()
    {
        $category =  QuestionCategory::from($this->getRawOriginal('category'));
        return [
            'name' => $category->name,
            'value' => $category->value,
        ];
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
