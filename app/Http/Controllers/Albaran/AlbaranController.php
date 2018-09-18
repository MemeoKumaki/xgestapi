<?php

namespace xgestapi\Http\Controllers\Albaran;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use xgestapi\Albaran;

class AlbaranController extends Controller
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
               
        $presupuesto = Albaran::where([
            ['BALBA', '>', 0]])
            ->whereBetween('BFECHA', [$fechaInicio, $fechaFin])
            ->with('lineas.articulo', 'lineas.numero_serie')->get();
        
        return response()->json(['data' => $presupuesto], 200);  
    
    }

    
}
