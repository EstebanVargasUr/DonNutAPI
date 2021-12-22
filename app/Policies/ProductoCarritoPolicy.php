<?php

namespace App\Policies;

use App\Models\ProductoCarrito;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductoCarritoPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isGranted(User::ROL_SUPERADMIN)) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductoCarrito  $productoCarrito
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProductoCarrito $productoCarrito)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductoCarrito  $productoCarrito
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProductoCarrito $productoCarrito)
    {
        return $user->carrito->idCarrito === $productoCarrito->fk_idCarrito;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductoCarrito  $productoCarrito
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProductoCarrito $productoCarrito)
    {
        return $user->carrito->idCarrito === $productoCarrito->fk_idCarrito;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductoCarrito  $productoCarrito
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProductoCarrito $productoCarrito)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductoCarrito  $productoCarrito
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProductoCarrito $productoCarrito)
    {
        //
    }
}
