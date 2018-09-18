<?php

namespace xgestapi\Http\Controllers\Categoria;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use xgestapi\Categoria;
class CategoriaArticuloController extends Controller
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
    public function index(Categoria $categoria)
    {
        $this->allowAdminAction();

        $categorias = Categoria::where('GINCLUWEB', 'S')
                ->where('GCOD', $categoria->GCOD)
                ->with('articulos')->get();
        return response()->json(['data' => $categorias], 200);
    }
    
    
}
