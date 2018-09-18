<?php

namespace xgestapi\Http\Controllers\Marca;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

use xgestapi\Marca;
use xgestapi\Articulo;

class MarcaArticuloController extends Controller
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
    public function index(Marca $marca)
    {
        $articulos = Marca::where('MMARCA', $marca->MMARCA)->with('articulos')->get();
        return response()->json(['data' => $articulos], 200); 
    }

    
}
