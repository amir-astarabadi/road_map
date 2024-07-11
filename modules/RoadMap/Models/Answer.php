<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\AnswerFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'question_id',
        'score',
    ];

    protected static function newFactory()
    {
        return new AnswerFactory();
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
