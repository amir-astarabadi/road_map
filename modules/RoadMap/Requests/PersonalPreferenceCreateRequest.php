<?php

namespace Modules\RoadMap\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Modules\RoadMap\Models\PersonalPreference;

class PersonalPreferenceCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        abort_if(PersonalPreference::isOpen()->belongsToUser(auth()->user())->exists(), Response::HTTP_FORBIDDEN, trans('open_form', ['number' => 1, 'form_name' => 'Personal Preference']));
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
            //
        ];
    }
}
