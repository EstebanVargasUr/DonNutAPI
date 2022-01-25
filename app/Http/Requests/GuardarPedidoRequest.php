<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarPedidoRequest extends FormRequest
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
            'pedido' => 'required|array',
            'pedido.estado' => 'max:11',
            'pedido.ubicLatitud' => 'required|numeric',
            'pedido.ubicLongitud' => 'required|numeric',
            'pedido.observacionUbicacion' => 'max:200',
            'pedido.observacionPedido' => 'max:200',
        ];
    }
}
