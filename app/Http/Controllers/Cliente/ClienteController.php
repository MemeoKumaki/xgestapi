<?php

namespace xgestapi\Http\Controllers\Cliente;

use xgestapi\Cliente;
use xgestapi\Centro;
use xgestapi\Albaran;
use xgestapi\Factura;
use Illuminate\Http\Request;
use xgestapi\Http\Controllers\Controller;

class ClienteController extends Controller
{
    
    public function __construct() {
        parent::__construct();
        $this->middleware('can:view,cliente')->only('show');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowAdminAction();
        
        $clientes = \xgestapi\Cliente::all();
        return response()->json(['data' => $clientes], 200);
        
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
            'nombre'    => 'required',
            'direccion' => 'required',
            'cp'        => 'required|digits:5',
            'poblacion' => 'required',
            'provincia' => 'required',
            'telefono'  => 'required|numeric',
            'dni'       => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ];
        
        $this->validate($request, $rules);

        $requestData = $request->all(array_keys($rules));
        $nextClienteId = Cliente::max('CCODCL') + 1;
        $datosCliente = [
            'CCODCL'    => $nextClienteId,
            'CNOM'      => $requestData['nombre'],
            'CDOM'      => $requestData['direccion'],
            'CCODPO'    => $requestData['cp'],
            'CPOB'      => $requestData['poblacion'],
            'CPAIS'     => $requestData['provincia'],
            'CTEL1'     => $requestData['telefono'],
            'CDNI'      => $requestData['dni'],
            'CMAIL1'    => $requestData['email'],
            'CNOMBREWEB'=> $nextClienteId,
            'CRESCAR4'  => $requestData['password'],
        ];
        
        $cliente = Cliente::create($datosCliente);
        $cliente->centros()->create(
                [
                    'ZCLI'      => $cliente->CCODCL,
                    'ZCEN'      => Centro::where('ZCLI', '=', $cliente->CCODCL)->max('ZCEN') + 1,
                    'ZNOM'      => $cliente->CNOM,
                    'ZDOM'      => $cliente->CDOM,
                    'ZCODPO'    => $cliente->CCODPO,
                    'ZPOB'      => $cliente->CPOB,
                    'ZPAIS'     => $cliente->CPAIS,
                    'ZTEL'      => $cliente->CTEL1,
                ]);
        
        return response()->json(['data' => $cliente], 201);
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
       
        $resultado = Cliente::with('centros')->findOrFail($cliente->CCODCL);
        return response()->json(['data' => $resultado], 200);
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
        
        $cliente = Cliente::findOrFail($id);
        
        $rules = [
            'cp'        => 'digits:5',
            'telefono'  => 'numeric',
            'email'     => 'email',
            'password'  => 'min:6',
        ];
        
        $this->validate($request, $rules);

        if($request->has('nombre')){
            $cliente->CNOM = $request->nombre;
        }
        if($request->has('direccion')){
            $cliente->CDOM = $request->direccion;
        }
        if($request->has('cp')){
            $cliente->CCODPO = $request->cp;
        }
        if($request->has('provincia')){
            $cliente->CPAIS = $request->provincia;
        }
        if($request->has('telefono')){
            $cliente->CTEL1 = $request->telefono;
        }
        if($request->has('dni')){
            $cliente->CDNI = $request->dni;
        }
        if($request->has('email')){
            $cliente->CMAIL1 = $request->email;
        }
        if($request->has('password')){
            $cliente->CRESCAR4 = $request->password;
        }
        
        if(!$cliente->isDirty()){
            return response()->json(['error' => 'Se debe especificar un valor diferente para actualizar', 
                'code' => 422], 422);
        }
        
        $cliente->save();
        return response()->json(['data' => $cliente], 201);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $this->allowAdminAction();
        
        $albaranes = Albaran::where('BCODCL', $cliente->CCODCL)->first();
        $facturas = Factura::where('FCODCL', $cliente->CCODCL)->first();;
        
        if($albaranes == null && $facturas == null){
            $cliente = Cliente::findOrFail($cliente->CCODCL);
            $cliente->delete();
        }else{
            $cliente->CBLOQUEADO = 'S';
            $cliente->save();
        }
        
        return response()->json('', 204);        
        
    }
}
