<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPedido'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_pedidos"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'idPedido',
        'estado',
        'fechaRegistro',
        'ubicLatitud',
        'ubicLongitud',
        'observacionUbicacion',
        'observacionPedido',
        'fk_idUsuarioCliente',
        'fk_idUsuarioRepartidor'
    ];
    protected $hidden = [
        'fk_idUsuarioCliente',
        'fk_idUsuarioRepartidor'
    ];

    public function cliente() 
    {
        return $this->belongsTo(User::class,'fk_idUsuarioCliente');
    }

    public function repartidor() 
    {
        return $this->belongsTo(User::class,'fk_idUsuarioRepartidor');
    }

    public function pedidoPendiente()
    {
        return $this->hasMany(PedidoPendiente::class,'fk_idPedido','idPedido');
    }

    public function pedidoProducto()
    {
        return $this->hasMany(PedidoProducto::class,'fk_idPedido','idPedido');
    }
}
