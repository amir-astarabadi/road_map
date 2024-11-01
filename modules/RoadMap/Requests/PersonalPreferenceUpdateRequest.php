<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\RoadMap\Enums\CourseFormat;
use Modules\RoadMap\Enums\Duration;
use Modules\RoadMap\Enums\NeedDegree;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus as Status;
use Modules\RoadMap\Enums\StudyAbroad;
use Modules\RoadMap\Enums\WorkExperience;
use Modules\RoadMap\Models\PersonalPreference;

class PersonalPreferenceUpdateRequest extends FormRequest
{

    private ?PersonalPreference $personalPreference;

    public function __construct()
    {
        parent::__construct();
        $this->personalPreference = $this->route('personal_preference') ?? PersonalPreference::getOrMakeAnOngoing();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $this->map();
        return [
            'career_id' => [
                'nullable',
                'integer',
                'exists:careers,id',
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::START->value))
            ],
            'budget' => [
                'nullable',
                'array',
                'size:2',
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::BUDGET->value))
            ],
            'budget.min' => ['sometimes', 'integer', 'min:0', 'max:1000000'],
            'budget.max' => ['sometimes', 'integer', 'min:0', 'max:1000000'],

            'work_experience' => [
                'nullable',
                'integer',
                'in:' . implode(',', WorkExperience::values()),
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::WORK_EXPERIENCE->value))
            ],

            'course_format' => [
                'nullable',
                'integer',
                'in:' . implode(',', CourseFormat::values()),
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::COURSE_FORMAT->value))
            ],

            'need_degree' => [
                'nullable',
                'integer',
                'in:' . implode(',', NeedDegree::values()),
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::DEGREE->value))
            ],

            'study_abroad' => [
                'nullable',
                'integer',
                'in:' . implode(',', StudyAbroad::values()),
                Rule::requiredIf($this->personalPreference?->isOnStatus(Status::STUDY_ABROAD->value))
            ],

            'duration' => [
                'nullable',
                'integer',
                'in:' . implode(',', Duration::values()),
                Rule::requiredIf($this->personalPreference->isOnStatus(Status::DURATION->value))
            ],
        ];
    }

    public function map()
    {
        $this->merge([
            'career_id' => $this->get('intrested_career', $this->personalPreference?->career_id),
            'budget' => $this->get('budget_amount', $this->personalPreference?->budget),
            'work_experience' => $this->get('work_experience', $this->personalPreference?->work_experience),
            'course_format' => $this->get('course_format', $this->personalPreference?->course_format),
            'need_degree' => $this->get('need_degree', $this->personalPreference?->need_degree),
            'duration' => $this->get('duration', $this->personalPreference?->duration),
            'study_abroad' => $this->get('study_abroad', $this->personalPreference?->study_abroad),
        ]);
    }

    public function getPersonalPreference()
    {
        return $this->personalPreference;
    }
}
