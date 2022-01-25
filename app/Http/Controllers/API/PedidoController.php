<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarPedidoRequest;
use App\Http\Requests\ActualizarPedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoPreparacionResource;
use App\Http\Resources\PedidoEntregaResource;
use App\Models\Pedido;
use App\Models\ProductoCarrito;
use App\Models\PedidoProducto;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::where('idPedido',$id)
        ->with(['cliente:idUsuario,nombre,primerApellido,segundoApellido,telefono',
        'repartidor:idUsuario,nombre,primerApellido,segundoApellido,email',
        'pedidoProducto:cantidad,fk_idPedido,fk_idProducto','pedidoProducto.producto:idProducto,nombre,imgProducto'])
        ->firstOrFail();
        
        $this->authorize('view', $pedido);

        return (new PedidoResource($pedido))
                ->response()
                ->setStatusCode(200);
    }

    public function getPreparacion()
    {
        $this->authorize('viewPreraracion', Pedido::class);

        $pedido = Pedido::has('pedidoPendiente')
        ->whereIn('estado',['PENDIENTE','PREPARACION'])
        ->with('cliente:idUsuario,nombre,primerApellido')
        ->get(['idPedido','estado','fechaRegistro','fk_idUsuarioCliente']);
        
        return (PedidoPreparacionResource::collection($pedido))
                ->response()
                ->setStatusCode(200);
    }

    public function getEntrega()
    {
        $this->authorize('viewEntrega', Pedido::class);

        $pedido = Pedido::has('pedidoPendiente')
        ->where('estado','ENTREGA')
        ->with(['cliente:idUsuario,nombre,primerApellido,segundoApellido,telefono',
        'repartidor:idUsuario,nombre,primerApellido,segundoApellido,email'])
        ->get(['idPedido','estado','fechaRegistro','fk_idUsuarioCliente','fk_idUsuarioRepartidor']);
        
        return (PedidoEntregaResource::collection($pedido))
                ->response()
                ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarPedidoRequest $request)
    { 
        //$repartidor = User::where('correo', 'repartidor@dn.com');
        $idCarrito = auth()->user()->carrito->idCarrito;

        $productos = ProductoCarrito::where('fk_idCarrito',$idCarrito)
        ->get(['cantidad','fk_idProducto'])->toArray(); 
        
        if($productos == []){
            return response(['msg' => 'Error no se cuenta con productos en el carrito'])->setStatusCode(406);
        }

        $pedido = Pedido::create($request->pedido + ['fk_idUsuarioCliente' => auth()->id(),'fk_idUsuarioRepartidor' => 1]);

        foreach($productos as $producto){
        
            PedidoProducto::Create($producto + ['fk_idPedido' => $pedido->idPedido]);
        }

        ProductoCarrito::where('fk_idCarrito',$idCarrito)->delete();

        return (new PedidoResource($pedido))
                ->additional(['msg' => 'Pedido registrado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarPedidoRequest $request, Pedido $pedido)
    {
        $this->authorize('update', $pedido);

        $pedido->update($request->all());
        return (new PedidoResource($pedido))
                ->additional(['msg' => 'Pedido actualizado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
