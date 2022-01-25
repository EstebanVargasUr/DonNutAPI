<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPedidoProducto'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_pedidosproductos"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'idPedidoProducto',
        'cantidad',
        'fk_idProducto',
        'fk_idPedido'
    ];
    protected $hidden = [
        'fk_idProducto',
        'fk_idPedido'
    ];

    public function pedido() 
    {
        return $this->belongsTo(Pedido::class,'fk_idPedido');
    }

    public function producto() 
    {
        return $this->belongsTo(Producto::class,'fk_idProducto');
    }
}
