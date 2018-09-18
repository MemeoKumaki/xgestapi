<?php

namespace xgestapi\Http\Controllers\Factura;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use xgestapi\Factura;

class FacturaController extends Controller
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
    public function index(Request $request)
    {
        
        $this->allowAdminAction();        
        
        $fechaInicio = $request->input('fecha_desde', \Carbon\Carbon::parse('-7 days')->format('Y-m-d'));
        $fechaFin = $request->input('fecha_hasta', \Carbon\Carbon::now()->format('Y-m-d'));
        
        $facturas = Factura::whereBetween('FFECHA', [$fechaInicio, $fechaFin])->get();
        return response()->json(['data' => $facturas], 200);  
    }

    
}
