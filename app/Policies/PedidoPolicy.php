<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PedidoPolicy
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
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pedido $pedido)
    {
        return $user->idUsuario === $pedido->fk_idUsuarioCliente || 
        $user->isGranted(User::ROL_REPARTIDOR) || $user->isGranted(User::ROL_PREPARADOR);
    }

    public function viewPreraracion(User $user)
    {
        return $user->isGranted(User::ROL_PREPARADOR);
    }

    public function viewEntrega(User $user)
    {
        return $user->isGranted(User::ROL_REPARTIDOR);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pedido $pedido)
    {
        return $user->idUsuario === $pedido->fk_idUsuarioCliente || 
        $user->isGranted(User::ROL_REPARTIDOR) || $user->isGranted(User::ROL_PREPARADOR);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pedido $pedido)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Pedido $pedido)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Pedido $pedido)
    {
        //
    }
}
