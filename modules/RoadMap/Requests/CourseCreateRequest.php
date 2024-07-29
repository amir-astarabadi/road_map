<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Rules\ValidateAnswer;

class CourseCreateRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasNotAddedThisCourse($this->course_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
        ];
    }
}
