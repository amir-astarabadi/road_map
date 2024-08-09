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

    public function scopeWhereProblemSolving(Builder $builder, ?string $value):Builder
    {
        return $builder->where('problem_solving', $value);
    }
    public function scopeWhereAiAndTech(Builder $builder, ?string $value):Builder
    {
        return $builder->where('ai_and_tech', $value);
    }
    public function scopeWhereSelfManagment(Builder $builder, ?string $value):Builder
    {
        return $builder->where('self_managment', $value);
    }
    public function scopeWhereLeaderShipAndPeppleSkills(Builder $builder, ?string $value):Builder
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
}
