<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Character extends Model
{

    protected $fillable = [
        "ai_and_tech",
        "self_managment",
        "problem_solving",
        "leader_ship_and_pepple_skills",
        'desc',
        'statment',
        'title',
        'image',
    ];

    public function scopeWhereProblemSolving(Builder $builder, ?string $value): Builder
    {
        return $builder->where('problem_solving', $value);
    }
    public function scopeWhereAiAndTech(Builder $builder, ?string $value): Builder
    {
        return $builder->where('ai_and_tech', $value);
    }
    public function scopeWhereSelfManagment(Builder $builder, ?string $value): Builder
    {
        return $builder->where('self_managment', $value);
    }
    public function scopeWhereLeaderShipAndPeppleSkills(Builder $builder, ?string $value): Builder
    {
        return $builder->where('leader_ship_and_pepple_skills', $value);
    }

    public function getImageUrlAttribute()
    {
        $image = empty($this->image) ? 'default.svg' : $this->image;

        return  Storage::disk('characters')->url($image);
    }

    public static function default()
    {
        $charachter = new self;

        $charachter->title = 'un known';
        $charachter->desc = 'you have so complicated charachter';
        $charachter->statment = 'there is no statment';

        return $charachter;
    }

    public static function empty()
    {
        $charachter = new self;

        $charachter->title = 'un known';
        $charachter->desc = 'character not set';
        $charachter->statment = 'character not set';

        return $charachter;
    }

    public static function nearest($examScores)
    {
        $result = ['diff_score' => 99999, 'character' => self::empty()];

        $map = ['low' => 1, 'medium' => 2, 'high' => 3];
        $tempDiff = 0;
        foreach (Character::all() as $charachter) {
            $tempDiff = abs($map[$charachter->ai_and_tech] - $map[$examScores->AI_AND_TECH]) +
                abs($map[$charachter->self_managment] - $map[$examScores->SELF_MANAGMENT]) +
                abs($map[$charachter->problem_solving] - $map[$examScores->PROBLEM_SOLVING]) +
                abs($map[$charachter->leader_ship_and_pepple_skills] - $map[$examScores->LEADER_SHIP_AND_PEPPLE_SKILLS]);

            if ($tempDiff < $result['diff_score']) {
                $result['diff_score'] = $tempDiff;
                $result['character'] = $charachter;
            }

            if ($tempDiff === 0) break;
        }

        return $result['character'];
    }
}
