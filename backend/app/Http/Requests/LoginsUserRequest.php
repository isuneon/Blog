<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginsUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
            'remember_me'    => 'sometimes|boolean'
        ];
    }


    public function messages()
    {
        return [
          'email.required'     => 'Por Favor, ingrese el correo.',
          'email.email'        => 'Por Favor, ingrese un correo valido.',
          'password.required'  => 'Por Favor, ingrese la contraseña.'
        ];
    }
}
