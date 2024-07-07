<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\CareerFactory;
use Illuminate\Database\Eloquent\Model;


class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
    ];

    protected static function newFactory()
    {
        return new CareerFactory();
    }
}
