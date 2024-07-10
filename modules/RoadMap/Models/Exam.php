<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\ExamFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'result',
    ];

    protected static function newFactory()
    {
        return new ExamFactory();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return Question::all();
    }

    public function result(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function scopeOnGoing(Builder $query):Builder
    {
        return $query->whereFinished(false);
    }

    public function scopeForUser(Builder $query, User $user):Builder
    {
        return $query->whereUserId($user->getKey());
    }

    public static function startFor(User $user)
    {
        $onGoingExam = static::onGoing()->forUser($user)->first();

        if ($onGoingExam) {
            return $onGoingExam;
        }

        return static::create(['user_id' => $user->getKey()]);
    }

    public function storeRawAnswershit()
    {
        $questions = Question::all(['id'])->map(fn ($q) => $q = ['exam_id' => $this->id, 'question_id' => $q->id]);
        DB::table('answershits')->insert($questions->toArray());
    }
}
