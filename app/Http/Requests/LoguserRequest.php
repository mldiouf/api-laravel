<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoguserRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' =>false,
            'status_code' => 422,
            'error' =>true,
            'message' => 'Erreur de validation',
            'errorslist' => $validator->errors(),
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'un nom doit etre fourni',
            'email.email' => 'adresse email non valide',
            'email.exists' => 'ce adresse email n existe pas',
            'password.required' => 'mot de pass non fourni',
        ];
    }
}
