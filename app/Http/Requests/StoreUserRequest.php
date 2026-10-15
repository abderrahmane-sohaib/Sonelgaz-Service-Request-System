<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'nomCL' => 'required|string|regex:/^[^0-9]*$/',
        ];
    }


    public function messages()
    {
        return [
            'nomCL.required' => 'Le champ nom est obligatoire.',
            'nomCL.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nomCL.regex' => 'Le champ nom ne doit pas contenir de chiffres.',
        ];
    }
}
