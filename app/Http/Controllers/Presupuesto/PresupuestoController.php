<?php

namespace xgestapi\Http\Controllers\Presupuesto;

use xgestapi\Presupuesto;
use xgestapi\Pedido;
use xgestapi\PresupuestoLinea;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;
use Carbon\Carbon;

class PresupuestoController extends Controller
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
        
        $presupuestos = Presupuesto::where([
            ['BOFE', '>', 0],
            ['BPED', '=', 0],
            ['BESPED', '=', 'N'],
            ['BLIQUID', '=', 'N']])
            ->whereBetween('BFECOFE', [$fechaInicio, $fechaFin])
            ->get();
        
        return response()->json(['data' => $presupuestos], 200);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->allowAdminAction();
        
        $rules = [
            'cliente_xgest'     => 'required|alpha_num|max:7',
        ];
        
        $this->validate($request, $rules);
        
        $datosPresupuesto = [
            'BOFE'      => Presupuesto::max('BOFE') + 1,
            'BPED'      => 0,
            'BESPED'    => 'N',
            'BCODCL'    => $request->cliente_xgest,
            'BFECOFE'   => Carbon::now()->toDateString(),
            'BHORAOFE'  => Carbon::now()->toTimeString(),
            'BLIQUID'   => 'N',
            'BALMACEN'  => 1,
        ];
        $presupuesto = Presupuesto::create($datosPresupuesto);
                
        return response()->json(['data' => $presupuesto], 201);
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
        
        $presupuesto = Presupuesto::findOrFail($id);
        return response()->json(['data' => $presupuesto], 200);        
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuesto $presupuesto)
    {
        $this->allowAdminAction();
        
        if($presupuesto->BLIQUID == 'N' 
                && $presupuesto->BPED == 0
                && $presupuesto->BOFE > 0){
            
            PresupuestoLinea::where([
                ['LPED', '=', 0],
                ['LOFE', '=', $presupuesto->BOFE],
                ['LLIQUID', '=', 'N']])->delete();            
            
            return response()->json('', 204 );
        }else{
            return response()->json([
                    'error' => 'No se puede eliminar el presupuesto.', 
                    'code' => 422
                ], 422);            
        }

    }
    
    
    public function checkout(Presupuesto $presupuesto)
    {
        $this->allowAdminAction();
        
        $pedidoId = Presupuesto::max('BPED') + 1;
        $presupuesto->BPED = $pedidoId;
        $presupuesto->BFECPED = Carbon::now()->toDateString();
        $presupuesto->BHORAPED = Carbon::now()->toTimeString();
        $presupuesto->BESPED = 'S';
        $presupuesto->save();
        
        PresupuestoLinea::where('LOFE', $presupuesto->BOFE)
                ->update(['LPED' => $pedidoId]);

        $pedido = Pedido::where([
            ['BPED', '=', $pedidoId],
            ['BESPED', '=', 'S']])
            ->with('lineas.articulo')->get();
        
        return response()->json(['data' => $pedido], 201);        

        
        
    }    
    
}
