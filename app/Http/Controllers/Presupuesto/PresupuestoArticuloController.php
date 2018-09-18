<?php

namespace xgestapi\Http\Controllers\Presupuesto;

use xgestapi\Presupuesto;
use xgestapi\PresupuestoLinea;
use xgestapi\Articulo;
use xgestapi\TipoImpuesto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class PresupuestoArticuloController extends Controller
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
    public function index(Request $request, Presupuesto $presupuesto)
    {
        $this->allowAdminAction();
        
        $resultado = $presupuesto->with('lineas')->get();
        return response()->json(['data' => $resultado], 200); 
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Presupuesto $presupuesto)
    {
        $this->allowAdminAction();
        
        $rules = [
            'articulo_id'   => 'required|string|max:28|exists:fcart001,ACODAR',
            'cantidad'      => 'required|alpha_num|max:5',
        ];
        
        $this->validate($request, $rules);
        $articulo = Articulo::findOrFail($request->articulo_id);
        if($articulo->ABLOQUEADO == 'S'){
            return response()->json(
                    ['error' => 'Artículo no disponible.', 'code' => 422], 
                    422);            
        }

        $impuestos = TipoImpuesto::where('TDESFEC', '<=', Carbon::now()->toDateString())
                ->where('THASFEC', '>=', Carbon::now()->toDateString())
                ->first()->toArray();
        
        $precioIva = (1 + ($impuestos['TIVA'.$articulo->ATIPIVA]/100)) * $articulo->APVP1 * $request->cantidad;
        $datosLinea = [
            'LOFE'      => $presupuesto->BOFE,
            'LLINEA'    => PresupuestoLinea::where('LOFE', $presupuesto->BOFE)->max('LLINEA') + 1,
            'LFECOFE'   => Carbon::now()->toDateString(),
            'LCODAR'    => $request->articulo_id,
            'LCODCL'    => $presupuesto->BCODCL,
            'LCANTI'    => $request->cantidad,
            'LPRECI'    => $articulo->APVP1,
            'LIMPOR'    => $request->cantidad * $articulo->APVP1,
            'LCANPEN'   => $request->cantidad,
            'LALMACEN'  => 1,
            'LTIPIVA'   => $articulo->ATIPIVA,
            'LPORCIVA'  => $impuestos['TIVA'.$articulo->ATIPIVA],
            'LPORCREC'  => $impuestos['TREC'.$articulo->ATIPIVA],
            'LIMPCONIVA'=> $precioIva,
            
        ];

        $linea = PresupuestoLinea::create($datosLinea);
        return response()->json(['data' => $linea], 201);            
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \xgestapi\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Presupuesto $presupuesto, $id)
    {
        $this->allowAdminAction();
        
        $linea = PresupuestoLinea::where('LOFE', $presupuesto->BOFE)
                ->where('LLINEA', $id)
                ->where('LPED', 0)
                ->where('LLIQUID', 'N')
                ->firstOrFail();
        
        return response()->json(['data' => $linea], 200);         
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \xgestapi\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presupuesto $presupuesto, $id)
    {
        $this->allowAdminAction();

        $rules = [
            'cantidad'      => 'required|alpha_num|max:5',
        ];
        $this->validate($request, $rules);
        
        $linea = PresupuestoLinea::where('LOFE', $presupuesto->BOFE)
                ->where('LLINEA', $id)
                ->where('LPED', 0)
                ->where('LLIQUID', 'N')
                ->firstOrFail();

        if($request->has('cantidad')){
            $precioIva = (1 + ($linea->LPORCIVA/100)) * $linea->LPRECI * $request->cantidad;

            $linea->LCANTI = $request->cantidad;
            $linea->LIMPOR = $linea->LPRECI * $request->cantidad;
            $linea->LCANPEN = $request->cantidad;
            $linea->LIMPCONIVA = $precioIva;         
        }

        if(!$linea->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }        
        
        $linea->save();
        return response()->json(['data' => $linea], 201);            
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \xgestapi\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuesto $presupuesto, $id)
    {
        $this->allowAdminAction();
        
        $linea = PresupuestoLinea::where('LOFE', $presupuesto->BOFE)
                ->where('LLINEA', $id)
                ->where('LPED', 0)
                ->where('LLIQUID', 'N')
                ->firstOrFail();
        
        $linea->delete();
        
        return response()->json('', 204);        
    }
}
