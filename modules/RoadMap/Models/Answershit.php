<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\CareerFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\RoadMap\Database\Factories\AnswerFactory;
use Modules\RoadMap\Database\Factories\AnswerShitFactory;
use Modules\RoadMap\Enums\QuestionCategory;

class Answershit extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'answer_id',
        'score',
    ];

    public static function newFactory(): AnswerShitFactory
    {
        return new AnswerShitFactory();
    }
}
