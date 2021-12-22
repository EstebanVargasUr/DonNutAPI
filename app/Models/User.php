<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'idUsuario'; //Define el nombre de la llave primaria de la tabla
    protected $table = "dn_usuarios"; //Define la tabla con la que va a trabajar el modelo
    const CREATED_AT  = null; //Desabilita la variable CREATED_AT
    const UPDATED_AT = null; //Desabilita la variable UPDATED_AT

    //Roles disponibles para los usuarios del sistema
    const ROL_SUPERADMIN = 'SUPERADMIN';
    const ROL_ADMIN = 'ADMIN';
    const ROL_REPARTIDOR = 'REPARTIDOR';
    const ROL_PREPARADOR = 'PREPARADOR';
    const ROL_USUARIO = 'USUARIO';


    //Jerarquía de roles
    private const ROLES_HIERARCHY = [
        self::ROL_SUPERADMIN => [self::ROL_ADMIN],
        self::ROL_ADMIN => [self::ROL_USUARIO],
        self::ROL_REPARTIDOR => [self::ROL_USUARIO],
        self::ROL_PREPARADOR => [self::ROL_USUARIO],
        self::ROL_USUARIO => []
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'idUsuario',
        'nombre',
        'primerApellido',
        'segundoApellido',
        'email',
        'password',
        'telefono',
        'fechaRegistro',
        'estado',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function carrito()
    {
        return $this->hasOne(Carrito::class,'fk_idUsuario');
    }

    public function isGranted($rol)
    {
        if ($rol === $this->rol) {
            return true;
        }
        return self::isRoleInHierarchy($rol, self::ROLES_HIERARCHY[$this->rol]);
    }

    private static function isRoleInHierarchy($rol, $rol_hierarchy)
    {
        if (in_array($rol, $rol_hierarchy)) {
            return true;
        }
        foreach ($rol_hierarchy as $rol_included) {
            if (self::isRoleInHierarchy($rol, self::ROLES_HIERARCHY[$rol_included])) {
                return true;
            }
        }
        return false;
    }
}
