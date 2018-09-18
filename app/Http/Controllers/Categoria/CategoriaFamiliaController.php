<?php

namespace xgestapi\Http\Controllers\Categoria;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

use xgestapi\Familia;
use xgestapi\Categoria;

class CategoriaFamiliaController extends Controller
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
    public function index(Categoria $categoria)
    {

        $familias = $categoria->familias()->get();
        return response()->json(['data' => $familias], 200);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Categoria $categoria)
    {
        
        $this->allowAdminAction();
        
        $rules = [
            'nombre'            => 'required|string|max:50',
            'observaciones'     => 'string',
            'meta_descripcion'  => 'string',
        ];
        
        $this->validate($request, $rules);

        $requestData = $request->all(array_keys($rules));

        $datosCategoria = [
            'FCOD'      => Familia::max('FCOD') + 1,
            'FDES'      => $requestData['nombre'],
            'FOBS'      => $requestData['observaciones'],
            'META_DESC' => $requestData['meta_descripcion'],
            'GINCLUWEB' => 'S',
            'FGRUPO'    => $categoria->GCOD,
            'XFECALTA'  => \Carbon\Carbon::now()->toDateString(),
        ];
        $familia = Familia::create($datosCategoria);
                
        return response()->json(['data' => $familia], 201);    
        
    }
    
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria, Familia $familia)
    {
        
        $this->allowAdminAction();        
        
        $resultado = $categoria->familias()->where('FCOD', $familia->FCOD)->get();
        return response()->json(['data' => $resultado], 200);
    }
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Familia $familia)
    {
        
        $this->allowAdminAction();

        $rules = [
            'nombre'            => 'string|max:50',
            'observaciones'     => 'string',
            'meta_descripcion'  => 'string',
        ];

        $this->validate($request, $rules);
        
        if($request->has('nombre')){
            $familia->GDES = $request->nombre;
        }
        if($request->has('observaciones')){
            $familia->GOBS = $request->observaciones;
        }
        if($request->has('meta_descripcion')){
            $familia->META_DESC = $request->meta_descripcion;
        }

        if(!$familia->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }
        
        $familia->save();
        return response()->json(['data' => $familia], 200);    }

        
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria, Familia $familia)
    {
        
        $this->allowAdminAction();        
        
        $resultado = $categoria->familias()->where('FCOD', $familia->FCOD)->with('articulos')->get();
        
        if(empty($resultado[0]->articulos->toArray())){
            $familia->delete();
            return response()->json('', 204 );
        }else{
            return response()->json([
                    'error' => 'La familia tiene articulos asociados.', 
                    'code' => 422
                ], 422);
        }
    }
}
