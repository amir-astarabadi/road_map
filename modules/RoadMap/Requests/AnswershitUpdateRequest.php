<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\RoadMap\Enums\CourseFormat;
use Modules\RoadMap\Enums\Duration;
use Modules\RoadMap\Enums\NeedDegree;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus as Status;
use Modules\RoadMap\Enums\WorkExperience;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Rules\ValidateAnswer;

class AnswershitUpdateRequest extends FormRequest
{

    private ?PersonalPreference $personalPreference;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('exam')->isOwnedBy(auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'answershit' => ['required', 'array', 'min:1', 'max:20', new ValidateAnswer()],
            'answershit.*.question_id' => ['required', 'bail', 'integer', 'exists:questions,id'], // 'min:1', 'max:20'
            'answershit.*.answer_id' => ['required', 'bail', 'integer'], // 'min:1', 'max:20'
        ];
    }
}
