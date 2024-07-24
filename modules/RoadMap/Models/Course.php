<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\CourseFactory;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'instructors',
        'level_up_from',
        'level_up_to',
        'url',
        'price',
        'skills',
        'channel',
        'number_of_pages',
        'duration',
        'type',
        'cover',
    ];

    protected $casts = [
        'level' => CourseLevel::class,
        'level_up_from' => CourseLevel::class,
        'level_up_to' => CourseLevel::class,
        'type' => CourseType::class,
    ];

    protected static function newFactory()
    {
        return new CourseFactory();
    }


    public function skills(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }


    public function levelUp(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->level_up_from->name . " -> " . $this->level_up_to->name,
        );
    }

    public function getPriceInDolarAttribute()
    {
        if (($this->price) === 0) {
            return "Free";
        }
        return  "$ " . $this->price / 100;
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
