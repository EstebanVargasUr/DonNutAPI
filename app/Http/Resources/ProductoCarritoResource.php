<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductoCarritoResource extends JsonResource
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
            'idProductoCarrito' => $this->idProductoCarrito,
            'cantidad' => $this->cantidad,
            'producto' => $this->producto
        ];
    }

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
