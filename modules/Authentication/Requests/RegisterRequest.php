<?php

namespace Modules\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Authentication\Enums\Sex;

class RegisterRequest extends FormRequest
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
        return [
            'first_name' => 'required|string|min:3|max:250',
            'last_name' => 'required|string|min:3|max:250',
            'sex' => 'required|integer|in:' . implode(',', Sex::values()),
            'email' => 'required|email|unique:users,email',
            'birth_date' => 'required|date|after_or_equal:' . now()->subYears(100)->startOfYear()->format('Y-m-d') . '|before_or_equal:' . now()->subYears(4)->startOfYear()->format('Y-m-d'),
            'password' => 'required|confirmed',
        ];
    }
}
