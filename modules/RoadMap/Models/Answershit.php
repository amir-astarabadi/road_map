<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\CareerFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\RoadMap\Database\Factories\AnswerFactory;
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
}
