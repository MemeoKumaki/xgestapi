<?php

namespace xgestapi;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    protected $fillable = ['name', 'uuid', 'password', 'remember_token', 'cliente_xgest', 'admin'];    
    
    public function findForPassport($username) {
        return $this->where('uuid', $username)->first();
    }
    
    
    public function esAdministrador()
    {
        $return = ($this->admin == 'S');
        return $return;
    }    

}
