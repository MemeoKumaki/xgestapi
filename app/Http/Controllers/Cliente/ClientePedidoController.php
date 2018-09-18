<?php

namespace xgestapi\Http\Controllers\Cliente;

use xgestapi\Cliente;
use xgestapi\Pedido;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class ClientePedidoController extends Controller
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
        
        $pedido = Pedido::where([
            ['BCODCL', '=', $cliente->CCODCL],
            ['BOFE', '>', 0],
            ['BESPED', '=', 'S'],
            ['BPED', '>', 0]])
            ->whereBetween('BFECPED', [$fechaInicio, $fechaFin])
            ->with('lineas.articulo')->get();
        
        return response()->json(['data' => $pedido], 200);  
    
    }

   
}
