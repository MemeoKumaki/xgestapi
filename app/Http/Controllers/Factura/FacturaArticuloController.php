<?php

namespace xgestapi\Http\Controllers\Factura;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use xgestapi\Factura;

class FacturaArticuloController extends Controller
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
    public function index(Request $request, Factura $factura)
    {
        $this->allowAdminAction();
        
        $resultado = Factura::where('FDOC', $factura->FDOC)->with('lineas', 'lineas.numero_serie')->get();
        return response()->json(['data' => $resultado], 200);  
    }

}
