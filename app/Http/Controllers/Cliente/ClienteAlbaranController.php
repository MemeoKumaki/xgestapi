<?php

namespace xgestapi\Http\Controllers\Cliente;

use xgestapi\Cliente;
use xgestapi\Albaran;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class ClienteAlbaranController extends Controller
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
               
        $presupuesto = Albaran::where([
            ['BCODCL', '=', $cliente->CCODCL],
            ['BALBA', '>', 0]])
            ->whereBetween('BFECHA', [$fechaInicio, $fechaFin])
            ->with('lineas.articulo', 'lineas.numero_serie')->get();
        
        return response()->json(['data' => $presupuesto], 200);  
    
    }


}
