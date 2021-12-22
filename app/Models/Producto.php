<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idProducto'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_productos"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'idProducto',
        'nombre',
        'tipo',
        'precio',
        'imgBanner',
        'imgProducto',
        'descripcion',
        'fechaRegistro',
        'estado'
    ];

    public function carritoProducto()
    {
        return $this->hasMany(CarritoProducto::class,'fk_idProducto','idProducto');
    }
}
