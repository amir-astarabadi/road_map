<?php

namespace Modules\RoadMap\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Factories\CourseFactory;
use Modules\RoadMap\Enums\CourseCategory;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'institute',
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
        'length',
        'type',
        'cover',
        'main_competency',
        'bonus_competencies',
        'language',
        'publisher',
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


    public function bonusCompetencies(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    public function mainCompetency(): HasOne
    {
        return $this->hasOne(Competency::class, 'id', 'main_competency');
    }

    public function exteraCompetencies(): HasMany
    {
        return $this->hasMany(Competency::class, 'id', 'bonus_competencies');
    }

    public function getLevelNameAttribute()
    {

        return CourseLevel::getName($this->getRawOriginal('level'));
    }

    public function competencies()
    {
        $all = array_merge($this->bonus_competencies, [$this->main_competency]);

        return Competency::whereIn('id', $all)->get();
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

    public function getImageUrlAttribute()
    {
        $image = empty($this->cover) ? 'default.png' : $this->cover;

        return  Storage::disk('courses')->url($image);
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

    public function getSkillsNameAttribute()
    {
        $values = [];

        foreach ($this->skills ?? [] as $skill) {
            $values[CourseCategory::getName($skill)] = $this->getLevelUpScore();
        }
        return $values;
    }

    public function getOnlySkillsNameAttribute()
    {
        $values = [];

        foreach ($this->skills ?? [] as $skill) {
            $values[] = CourseCategory::toHuman(CourseCategory::getName($skill));
        }
        return $values;
    }

    public function move(array $result)
    {
        $courses = auth()->user()->courses ?? [];
        $data = [];
        foreach ($courses as $course) {
            $data = array_merge($data, $course->skills_name);
        }

        foreach ($result as $key => $value) {

            if (isset($data[$key])) {
                $result[$key] += $data[$key];
            }
        }
        return $result;
    }

    public function getLevelUpScore()
    {
        return ($this->level_up_to->value - $this->level_up_from->value) * 5;
    }

    public function getFinalLevelAttribute()
    {
        return $this->level_up_to->value  *  5;
    }
}
