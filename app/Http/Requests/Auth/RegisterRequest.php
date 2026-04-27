<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vārds ir obligāts.',
            'name.string' => 'Vārds ir jābūt teksts.',
            'name.max' => 'Vārds nedrīkst pārsniegt 255 rakstzīmes.',

            'email.required' => 'E-pasts ir obligāts.',
            'email.string' => 'E-pasts ir jābūt teksts.',
            'email.email' => 'E-pasts ir jābūt derīga e-pasta adrese.',
            'email.max' => 'E-pasts nedrīkst pārsniegt 255 rakstzīmes.',
            'email.unique' => 'Šis e-pasts jau ir reģistrēts.',

            'password.required' => 'Parole ir obligāta.',
            'password.confirmed' => 'Paroles nesakrīt.',
            'password.min' => 'Parole jābūt vismaz 8 rakstzīmes.',
            'password.password' => 'Parole ir jābūt droša un jāatbilst prasībām.',
        ];
    }
}
