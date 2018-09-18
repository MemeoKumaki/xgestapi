<?php

namespace xgestapi\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    protected function allowAdminAction(){
        if(Gate::denies('admin-action')){
            throw new AuthorizationException('Operacion no autorizada.');
        }        
    }
}
