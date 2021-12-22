<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'idProducto' => $this->idProducto,
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'precio' => $this->precio,
            'imgBanner' => $this->imgBanner,
            'imgProducto' => $this->imgProducto,
            'descripcion' => $this->descripcion,
            'fechaRegistro' => $this->fechaRegistro,
            'estado' => $this->estado
        ];
    }

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
