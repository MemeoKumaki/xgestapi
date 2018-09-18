<?php

namespace xgestapi\Http\Controllers\Albaran;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use xgestapi\Albaran;

class AlbaranArticuloController extends Controller
{
    
    public function __construct() 
    {
        parent::__construct();
    }   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Albaran $albaran)
    {
        $this->allowAdminAction();       
        
        $resultado = Albaran::with('lineas')->get();
        return response()->json(['data' => $resultado], 200);  
    }

    
}
