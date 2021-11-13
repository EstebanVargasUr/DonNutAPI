<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthRequest extends FormRequest
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
            'nombre' => 'required',
            'primerApellido' => 'required',
            'segundoApellido' => 'required',
            'email' => 'required|string|email|max:50|unique:dn_usuarios,email',
            'password' => 'required:string',
            'telefono' => 'required',
            'fechaRegistro' => 'required',
            'estado' => 'required',
            'fk_idRol' => 'required',
        ];
    }
}
