<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
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
            'idPedido' => $this->idPedido,
            'estado' => $this->estado,
            'fechaRegistro' => $this->fechaRegistro,
            'ubicLatitud' => $this->ubicLatitud,
            'ubicLongitud' => $this->ubicLongitud,
            'observacionUbicacion' => $this->observacionUbicacion,
            'observacionPedido' => $this->observacionPedido,
            'cliente' => $this->cliente,
            'repartidor' => $this->repartidor,
            'productos' => $this->pedidoProducto
        ];
    }

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
