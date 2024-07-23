<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\CourseFactory;
use Modules\RoadMap\Enums\CourseLevel;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'level_up_from',
        'level_up_to',
        'url',
        'price',
        'courseable_type',
        'courseable_id',
    ];

    protected $casts = [
        'level' => CourseLevel::class,
        'level_up_from' => CourseLevel::class,
        'level_up_to' => CourseLevel::class,
    ];

    protected static function newFactory()
    {
        return new CourseFactory();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attachToUser(User $user)
    {
        $this->users()->sync([$user->getKey()]);
    }
}
