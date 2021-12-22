<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCarrito extends Model
{
    use HasFactory;

    protected $primaryKey = 'idProductoCarrito'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_productoscarrito"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'idProductoCarrito',
        'fechaRegistro',
        'cantidad',
        'fk_idCarrito',
        'fk_idProducto'
    ];

    public function carrito() 
    {
        return $this->belongsTo(Carrito::class,'fk_idCarrito');
    }

    public function producto() 
    {
        return $this->belongsTo(Producto::class,'fk_idProducto');
    }
}
