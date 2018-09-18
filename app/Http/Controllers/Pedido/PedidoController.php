<?php

namespace xgestapi\Http\Controllers\Pedido;

use xgestapi\Pedido;
use xgestapi\PedidoLinea;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use Carbon\Carbon;

class PedidoController extends Controller
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
        
        $fechaInicio = $request->input('desde', Carbon::parse('first day of January')->format('Y-m-d'));
        $fechaFin = $request->input('hasta', Carbon::now()->format('Y-m-d'));
        
        $pedidos = Pedido::where([
            ['BOFE', '>', 0],
            ['BPED', '>', 0],
            ['BESPED', '=', 'S'],
            ['BLIQUID', '=', 'N']])
            ->whereBetween('BFECPED', [$fechaInicio, $fechaFin])
            ->get();
        
        return response()->json(['data' => $pedidos], 200);
        
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->allowAdminAction();
        
        $pedido = Pedido::findOrFail($id);
        return response()->json(['data' => $pedido], 200);        
        
    }

 
    
}
