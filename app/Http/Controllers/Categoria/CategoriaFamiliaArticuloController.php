<?php

namespace xgestapi\Http\Controllers\Categoria;

use xgestapi\Familia;
use xgestapi\Categoria;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class CategoriaFamiliaArticuloController extends Controller
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
    public function index(Categoria $categoria, Familia $familia)
    {
        
        $this->allowAdminAction();        
        
        $articulos = $familia->articulos()->get();
        return response()->json(['data' => $articulos], 200);
    }


}
