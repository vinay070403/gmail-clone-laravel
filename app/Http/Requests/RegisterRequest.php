<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guest only (route will also use guest middleware)
    }

    // Normalize input first (trim, lowercase email)
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'  => is_string($this->name) ? trim($this->name) : $this->name,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'min:3', 'max:100'],
            'email' => ['bail', 'required', 'string', 'email:rfc,dns', 'max:150', 'unique:users,email'],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                // complexity: at least 1 lower, 1 upper, 1 digit, 1 symbol
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must include upper, lower, number, and symbol.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'email address',
        ];
    }
}
            