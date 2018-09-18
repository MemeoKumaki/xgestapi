<?php

namespace xgestapi\Http\Controllers\Cliente;

use xgestapi\Cliente;
use xgestapi\Factura;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class ClienteFacturaController extends Controller
{
    
    public function __construct() {
        parent::__construct();
        $this->middleware('can:view,cliente')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Cliente $cliente)
    {
        
        $fechaInicio = $request->input('desde', \Carbon\Carbon::parse('first day of January')->format('Y-m-d'));
        $fechaFin = $request->input('hasta', \Carbon\Carbon::now()->format('Y-m-d'));
        
        $facturas = Factura::where([['FCODCL', $cliente->CCODCL]])
                ->whereBetween('FFECHA', [$fechaInicio, $fechaFin])
                ->with('lineas', 'lineas.numero_serie')->get();
        
        return response()->json(['data' => $facturas], 200);  
    
    }

    
}
