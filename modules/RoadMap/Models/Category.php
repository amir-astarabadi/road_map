<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoadMap\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    protected static function newFactory()
    {
        return new CategoryFactory();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
