<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('albaranes', 'Albaran\AlbaranController', ['only' => ['index']]);
Route::resource('albaranes.articulos', 'Albaran\AlbaranArticuloController', ['only' => ['index']]);

Route::resource('articulos', 'Articulo\ArticuloController', ['except' => ['create', 'edit']]);

Route::resource('categorias', 'Categoria\CategoriaController', ['except' => ['create', 'edit']]);
Route::resource('categorias.articulos', 'Categoria\CategoriaArticuloController', ['only' => ['index']]);
Route::resource('categorias.familias', 'Categoria\CategoriaFamiliaController', ['except' => ['create', 'edit']]);
Route::resource('categorias.familias.articulos', 'Categoria\CategoriaFamiliaArticuloController', ['only' => ['index']]);

Route::resource('clientes', 'Cliente\ClienteController', ['except' => ['create', 'edit']]);
Route::resource('clientes.presupuestos', 'Cliente\ClientePresupuestoController', ['only' => ['index']]);
Route::resource('clientes.pedidos', 'Cliente\ClientePedidoController', ['only' => ['index']]);
Route::resource('clientes.albaranes', 'Cliente\ClienteAlbaranController', ['only' => ['index']]);
Route::resource('clientes.facturas', 'Cliente\ClienteFacturaController', ['only' => ['index']]);

Route::resource('facturas', 'Factura\FacturaController', ['only' => ['index']]);
Route::resource('facturas.articulos', 'Factura\FacturaArticuloController', ['only' => ['index']]);

Route::resource('marcas', 'Marca\MarcaController', ['except' => ['create', 'edit']]);
Route::resource('marcas.articulos', 'Marca\MarcaArticuloController', ['only' => ['index']]);

Route::resource('pedidos', 'Pedido\PedidoController', ['only' => ['index']]);

Route::resource('presupuestos', 'Presupuesto\PresupuestoController', ['except' => ['create', 'edit']]);
Route::resource('presupuestos.articulos', 'Presupuesto\PresupuestoArticuloController', ['except' => ['create', 'edit']]);
Route::name('checkout')->post('presupuestos/{presupuesto}/checkout', 'Presupuesto\PresupuestoController@checkout');

Route::resource('user', 'User\UserController', ['only' => ['create']]);


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

