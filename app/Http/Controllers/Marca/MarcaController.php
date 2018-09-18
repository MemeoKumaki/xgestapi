<?php

namespace xgestapi\Http\Controllers\Marca;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

use xgestapi\Marca;

class MarcaController extends Controller
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
        
        $marcas = Marca::all();
        return response()->json(['data' => $marcas], 200);
        
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
            'marca'         => 'required|unique:fcmar001,mmarca|string|max:30',
            'descripcion'   => 'required|max:100',
            'web'           => 'required|url',
        ];
        
        $this->validate($request, $rules);

        $requestData = $request->all(array_keys($rules));
        
        $datosMarca = [
            'MMARCA'    => $requestData['marca'],
            'MDESCR'    => $requestData['descripcion'],
            'MWEB'      => $requestData['web'],
            'XFECALTA'  => \Carbon\Carbon::now()->toDateString(),
        ];
        
        $marca = Marca::create($datosMarca);
                
        return response()->json(['data' => $marca], 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = Marca::findOrFail($id);
        return response()->json(['data' => $marca], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->allowAdminAction();
        
        $marca = Marca::findOrFail($id);
        
        $rules = [
            'descripcion'   => 'max:100',
            'web'           => 'url',
        ];

        $this->validate($request, $rules);
        
        if($request->has('descripcion')){
            $marca->MDESCR = $request->descripcion;
        }
        if($request->has('web')){
            $marca->MWEB = $request->web;
        }

        if(!$marca->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }
        
        $marca->save();
        return response()->json(['data' => $marca], 200);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        $this->allowAdminAction();
        
        $articulos = $marca->articulos()->get();

        if(empty($articulos->toArray())){
            
            $marca->delete();
            return response()->json('', 204 );
            
        }else{
            
            return response()->json([
                    'error' => 'La marca tiene artículos asociados.', 
                    'code' => 422
                ], 422);
            
        }
        
    }
}
