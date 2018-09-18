<?php

namespace xgestapi\Http\Controllers\User;

use Webpatser\Uuid\Uuid;
use xgestapi\User;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct() {
        parent::__construct();
    }    
    

    
    public function registro(Request $request)
    {
        $this->allowAdminAction();
        
        $rules = [
            'nombre'        => 'required|string',
            'password'      => 'required|string',
            'cliente_xgest' => 'numeric|unique:users,cliente_xgest',
        ];

        
        $this->validate($request, $rules);
        
        $usuario = User::create([
            'name'          => $request->nombre,
            'uuid'          => Uuid::generate(4),
            'password'      => bcrypt($request->password),
            'cliente_xgest' => $request->input('cliente_xgest', NULL),
            'admin'         => 'N',
        ]);
        if($usuario->save()){
            return response()->json(['data' => $usuario], 201);  
        }else{
            return response()->json(['error' => 'Cliente de xgest ya existe.', 'code' => 409], 409);  
        }
        
    
    }
    

}
