<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoPendiente extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPedidoPendiente'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_pedidospendientes"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'idPedidoPendiente',
        'fk_idPedido'
    ];

    public function pedido() 
    {
        return $this->belongsTo(Pedido::class,'fk_idPedido');
    }
}
