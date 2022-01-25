<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoEntregaResource extends JsonResource
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
            'cliente' => $this->cliente,
            'repartidor' => $this->repartidor,
        ];
    }

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
