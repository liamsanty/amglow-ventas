<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        // Si el reCAPTCHA está configurado, se valida en el servidor
        if (config('captcha.sitekey') && config('captcha.secret')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Marca la casilla "No soy un robot".',
            'g-recaptcha-response.captcha' => 'No se pudo verificar el captcha. Inténtalo de nuevo.',
        ];
    }
}
