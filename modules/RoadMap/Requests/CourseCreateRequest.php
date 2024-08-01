<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Rules\ValidateAnswer;

class CourseCreateRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->user()->hasNotAddedThisCourse($this->course_id)) {
            abort(Response::HTTP_FORBIDDEN, 'This course has been added to your profile.');
        }
        
        return true;
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
