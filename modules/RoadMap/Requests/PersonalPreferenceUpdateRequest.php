<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;

class PersonalPreferenceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->map();
        return [
            'budget' => [
                'nullable',
                'integer',
                'min:1',
                'max:100000',
                Rule::requiredIf($this->route('personal_preference')->isOnStatus([PersonalPreferencesProcessStatus::START, PersonalPreferencesProcessStatus::BUDGET]))
            ],

            'course_length_type' => [
                'nullable',
                'string',
                'in:' . implode(',', CourseLength::values()),
                Rule::requiredIf($this->route('personal_preference')->isOnStatus(PersonalPreferencesProcessStatus::COURSE_LENGTH))
            ],

            'course_location_type' => [
                'nullable',
                'string',
                'in:' . implode(',', CourseLocation::values()),
                Rule::requiredIf($this->route('personal_preference')->isOnStatus(PersonalPreferencesProcessStatus::COURSE_LOCATION))
            ],

            'industries' => [
                'nullable',
                'array',
                Rule::requiredIf($this->route('personal_preference')->isOnStatus(PersonalPreferencesProcessStatus::INDUSTRIES))
            ],
            'industries.*' => ['string', 'min:2', 'max:20'],

            'jobs' => [
                'nullable',
                'array',
                Rule::requiredIf($this->route('personal_preference')->isOnStatus(PersonalPreferencesProcessStatus::JOBS))
            ],
            'jobs.*' => ['string', 'min:2', 'max:20']
        ];
    }

    public function map()
    {
        $this->merge([
            'budget' => $this->get('budget_amount', $this->route('personal_preference')->budget),
            'course_length_type' => $this->get('course_length', $this->route('personal_preference')->course_length_type),
            'course_location_type' => $this->get('course_location', $this->route('personal_preference')->course_location_type),
            'industries' => $this->get('intrested_industries', $this->route('personal_preference')->industries),
            'jobs' => $this->get('intrested_jobs', $this->route('personal_preference')->jobs),
        ]);
    }
}
