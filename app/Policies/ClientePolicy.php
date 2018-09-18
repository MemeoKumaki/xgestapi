<?php

namespace xgestapi\Policies;

use xgestapi\User;
use xgestapi\Cliente;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){

        if($user->esAdministrador()){
            return true;
        }
    }
    
    
    
    /**
     * Determine whether the user can view the cliente.
     *
     * @param  \xgestapi\User  $user
     * @param  \xgestapi\Cliente  $cliente
     * @return mixed
     */
    public function view(User $user, Cliente $cliente)
    {
        if($user->cliente_xgest === $cliente->CCODCL){
            return true;
        }
    }

    /**
     * Determine whether the user can create clientes.
     *
     * @param  \xgestapi\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the cliente.
     *
     * @param  \xgestapi\User  $user
     * @param  \xgestapi\Cliente  $cliente
     * @return mixed
     */
    public function update(User $user, Cliente $cliente)
    {
        if($user->cliente_xgest === $cliente->CCODCL){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the cliente.
     *
     * @param  \xgestapi\User  $user
     * @param  \xgestapi\Cliente  $cliente
     * @return mixed
     */
    public function delete(User $user, Cliente $cliente)
    {
        //
    }
}
