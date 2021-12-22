<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carrito extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCarrito'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_carritos"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null;
    const UPDATED_AT = null;
    
    protected $fillable = [
        'idCarrito',
        'fk_idUsuario'
    ];
    
    public static function boot() 
    {
        parent::boot();
        static::creating(function ($carrito){
            $carrito->fk_idUsuario = Auth::id();
        });
    }

    public function user() 
    {
        return $this->belongsTo(User::class,'fk_idUsuario');
    }

    public function carritoProducto()
    {
        return $this->hasMany(CarritoProducto::class,'fk_idCarrito','idCarrito');
    }
}
