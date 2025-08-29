<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guest users can reset
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
            'token' => is_string($this->token) ? trim($this->token) : $this->token,
        ]);
    }

    public function rules(): array
    {
        return [
            'token' => ['bail', 'required', 'string', 'min:10', 'max:255'],
            'email' => ['bail', 'required', 'string', 'email:rfc,dns', 'max:150', 'exists:users,email'],
            'password' => [
                'bail', 'required', 'string', 'min:8', 'max:255', 'confirmed',
                // Complexity: at least one lower, one upper, one digit, one symbol
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
            'password.regex' => 'Password must include an uppercase letter, a lowercase letter, a number, and a symbol.',
            'email.exists' => 'We could not find an account with that email.',
        ];
    }

    public function attributes(): array
    {
        return [
            'token' => 'reset token',
            'email' => 'email address',
        ];
    }
}
