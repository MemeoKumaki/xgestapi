<?php

namespace xgestapi\Http\Controllers\Categoria;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

use xgestapi\Categoria;

class CategoriaController extends Controller
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
    public function index()
    {
        $this->allowAdminAction();

        $categorias = Categoria::where('GINCLUWEB', 'S')->get();
        return response()->json(['data' => $categorias], 200);
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
            'nombre'            => 'required|string|max:50',
            'observaciones'     => 'string',
            'meta_descripcion'  => 'string',
        ];
        
        $this->validate($request, $rules);

        $requestData = $request->all(array_keys($rules));
        
        $datosCategoria = [
            'GCOD'      => Categoria::max('GCOD') + 1,
            'GDES'      => $requestData['nombre'],
            'GOBS'      => $requestData['observaciones'],
            'META_DESC' => $requestData['meta_descripcion'],
            'GINCLUWEB' => 'S',
            'XFECALTA'  => \Carbon\Carbon::now()->toDateString(),
        ];
        $categoria = Categoria::create($datosCategoria);
                
        return response()->json(['data' => $categoria], 201);
        
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        $this->allowAdminAction();

        $resultado = Categoria::findOrFail($categoria);
        return response()->json(['data' => $resultado], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $this->allowAdminAction();
        
        $rules = [
            'nombre'            => 'string|max:50',
            'observaciones'     => 'string',
            'meta_descripcion'  => 'string',
        ];

        $this->validate($request, $rules);
        
        if($request->has('nombre')){
            $categoria->GDES = $request->nombre;
        }
        if($request->has('observaciones')){
            $categoria->GOBS = $request->observaciones;
        }
        if($request->has('meta_descripcion')){
            $categoria->META_DESC = $request->meta_descripcion;
        }

        if(!$categoria->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }
        
        $categoria->save();
        return response()->json(['data' => $categoria], 200);    }

        
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        
        $familias = $categoria->familias()->get();

        if(empty($familias->toArray())){
            
            $categoria->delete();
            return response()->json('', 204 );
            
        }else{
            
            return response()->json([
                    'error' => 'La categoria tiene familias asociadas.', 
                    'code' => 422
                ], 422);
            
        }
    }
}
