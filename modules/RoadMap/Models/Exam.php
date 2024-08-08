<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\ExamFactory;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'result',
        'finished_at',
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

    public function scopeOnGoing(Builder $query): Builder
    {
        return $query->whereNull('finished_at');
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereUserId($user->getKey());
    }

    public function isOwnedBy(User $user)
    {
        return $user->getKey() === $this->user_id;
    }

    public function isOnGoing()
    {
        return is_null($this->finished_at);
    }

    public static function startFor(User $user)
    {
        $onGoingExam = static::onGoing()->forUser($user)->first();

        if ($onGoingExam) {
            return $onGoingExam;
        }

        return static::create(['user_id' => $user->getKey()]);
    }

    public function storeAnswershit(array $answershit): void
    {
        $answershit = array_column($answershit, 'answer_id', 'question_id');
        $scores = DB::table('questions')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->whereIn('answers.id', array_values($answershit))
            ->selectRaw("{$this->getKey()} as exam_id")
            ->selectRaw("answers.id as answer_id")
            ->selectRaw("questions.id as question_id")
            ->selectRaw("now() as created_at")
            ->selectRaw("now() as updated_at")
            ->selectRaw("score")
            ->get()
            ->toArray();

        // convert from std class to array
        $scores = json_decode(json_encode($scores, true), true);

        DB::table('answershits')->upsert($scores, ['exam_id', 'question_id']);
    }

    public function updateResult()
    {
        $result = Answershit::whereExamId($this->getKey())
            ->join('questions', 'questions.id', '=', 'question_id')
            ->selectRaw($this->mapCategoryQuery())
            ->selectRaw('competency')
            ->selectRaw('sum(score) as score')
            ->groupBy('category')
            ->groupBy('competency')
            ->get();
        $totalScores = [];
        foreach (QuestionCategory::cases() as $case) {
            $totalScores['category'][$case->name] = $result->where('category', $case->name)->sum('score');
        }

        foreach (QuestionCompetency::cases() as $case) {
            $totalScores['competency'][$case->name] = $result->where('competency', $case->value)->sum('score');
        }

        $this->update(['result' => $totalScores, 'finished_at' => now()]);
    }

    private function mapCategoryQuery()
    {
        return "IF( category = " . QuestionCategory::PROBLEM_SOLVING->value . ", '" . QuestionCategory::PROBLEM_SOLVING->name . "', " .
            "IF( category = " . QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS->value . ", '" . QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS->name . "' , " .
            "IF( category = " . QuestionCategory::SELF_MANAGMENT->value . ", '" . QuestionCategory::SELF_MANAGMENT->name . "' , " .
            "IF( category = " . QuestionCategory::AI_AND_TECH->value . ", '" . QuestionCategory::AI_AND_TECH->name . "' , NULL)))) as category";
    }

    public static function avg()
    {
        $avg = [
            "PROBLEM_SOLVING" => 0,
            "LEADER_SHIP_AND_PEPPLE_SKILLS" => 0,
            "SELF_MANAGMENT" => 0,
            "AI_AND_TECH" => 0
        ];

        $results = static::query()
            ->whereNotNull('finished_at')
            ->select('result')
            ->get()
            ->pluck('result.category')
            ->toArray();

        if (empty($results)) {
            return $avg;
        }

        foreach ($results as $result) {
            $avg['PROBLEM_SOLVING'] += $result->PROBLEM_SOLVING;
            $avg['LEADER_SHIP_AND_PEPPLE_SKILLS'] += $result->LEADER_SHIP_AND_PEPPLE_SKILLS;
            $avg['SELF_MANAGMENT'] += $result->SELF_MANAGMENT;
            $avg['AI_AND_TECH'] += $result->AI_AND_TECH;
        }

        return [
            "PROBLEM_SOLVING" => intval($avg['PROBLEM_SOLVING'] / count($results)),
            "LEADER_SHIP_AND_PEPPLE_SKILLS" => intval($avg['LEADER_SHIP_AND_PEPPLE_SKILLS'] / count($results)),
            "SELF_MANAGMENT" => intval($avg['SELF_MANAGMENT'] / count($results)),
            "AI_AND_TECH" => intval($avg['AI_AND_TECH'] / count($results)),
        ];
    }
}
