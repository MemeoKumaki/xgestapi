<?php

namespace xgestapi\Http\Controllers\Articulo;

use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

use xgestapi\Articulo;

class ArticuloController extends Controller
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
        $articulos = Articulo::all();
        return response()->json(['data' => $articulos], 200);
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
            'articulo_id'   => 'required|unique:fcart001,ACODAR|string|max:28',
            'descripcion'   => 'required|string|max:150',
            'ean'           => 'alpha_num|max:13',
            'partnumber'    => 'string|max:20',
            'precio'        => 'alpha_num',
            'precio_base'   => 'alpha_num',
            'marca'         => 'alpha_num|exists:fcfam001,MMARCA',
            'familia_id'    => 'alpha_num|exists:fcfcp001,FCOD',
            'largo'         => 'alpha_num',
            'ancho'         => 'alpha_num',
            'alto'          => 'alpha_num',
            'peso'          => 'alpha_num',
        ];
                         
        $this->validate($request, $rules);        
        
        $datosArticulo = [
            'ACODAR'    => $request->articulo_id,
            'adescr'    => $request->descripcion,
            'AMARCA'    => $request->input('marca', ''),
            'ACARAC'    => $request->input('caracteristicas', 0),
            'ACODALT2'  => $request->input('ean', ''),
            'ARESCAR1'  => $request->input('partnumber', ''),
            'APVP1'     => $request->input('precio', 0),
            'APREBASE'  => $request->input('precio_base', 0),
            'ARESNUM4'  => $request->input('familia_id', 0),
            'APESO'     => $request->input('peso', 0),
            'ALARGO'    => $request->input('largo', 0),
            'AANCHO'    => $request->input('ancho', 0),
            'AALTO'     => $request->input('alto', 0),
            'APESO'     => $request->input('peso', 0),
            'XFECALTA'  => \Carbon\Carbon::now()->toDateString(),
        ];
        
        $articulo = Articulo::create($datosArticulo);
        return response()->json(['data' => $articulo], 201);        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulo = Articulo::findOrFail($id);
        return response()->json(['data' => $articulo], 200);
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
        
        $articulo = Articulo::findOrFail($id);
        
        $rules = [
            'descripcion'   => 'string|max:150',
            'ean'           => 'alpha_num|max:13',
            'partnumber'    => 'string|max:20',
            'precio'        => 'alpha_num',
            'precio_base'   => 'alpha_num',
            'marca'         => 'alpha_num|exists:fcfam001,MMARCA',            
            'familia_id'    => 'alpha_num|exists:fcfcp001,FCOD',
            'largo'         => 'alpha_num',
            'ancho'         => 'alpha_num',
            'alto'          => 'alpha_num',
            'peso'          => 'alpha_num',
        ];

        $this->validate($request, $rules);
        
        if($request->has('descripcion')){
            $articulo->adescr = $request->descripcion;
        }
        if($request->has('ean')){
            $articulo->ACODALT2 = $request->ean;
        }
        if($request->has('partnumber')){
            $articulo->ARESCAR1 = $request->partnumber;
        }
        if($request->has('precio')){
            $articulo->APVP1 = $request->precio;
        }
        if($request->has('precio_base')){
            $articulo->APREBASE = $request->precio_base;
        }
        if($request->has('marca')){
            $articulo->AMARCA = $request->marca;
        }
        if($request->has('familia_id')){
            $articulo->ARESNUM4 = $request->familia_id;
        }
        if($request->has('largo')){
            $articulo->ALARGO = $request->largo;
        }
        if($request->has('ancho')){
            $articulo->AANCHO = $request->ancho;
        }
        if($request->has('alto')){
            $articulo->AALTO = $request->alto;
        }
        if($request->has('peso')){
            $articulo->APESO = $request->peso;
        }

        if(!$articulo->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }
        
        $articulo->save();
        return response()->json(['data' => $articulo], 200);
        
    }

    /**
     * Bloquea un articulo (borrado logico)
     *
     * @param  string  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        $this->allowAdminAction();
        
        $articulo->ABLOQUEADO = 'S';
        $articulo->save();
        
        return response()->json('', 204);
        
    }
}
