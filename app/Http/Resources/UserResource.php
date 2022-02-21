<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
        'idUsuario' => $this->idUsuario,
        'nombre' => $this->nombre,
        'primerApellido' => $this->primerApellido,
        'segundoApellido' => $this->SegundoApellido,
        'email' => $this->email,
        'telefono' => $this->telefono,
        'fechaRegistro' => $this->fechaRegistro,
        'estado' => $this->estado,
        'rol' => $this->rol

        ];
    }

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
