<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarProductoCarritoRequest;
use App\Http\Requests\ActualizarProductoCarritoRequest;
use App\Http\Resources\ProductoCarritoResource;
use App\Models\ProductoCarrito;

class ProductoCarritoController extends Controller
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
        $productoCarrito = ProductoCarrito::where('fk_idCarrito',auth()->user()->carrito->idCarrito)
        ->with('producto:idProducto,nombre,tipo,precio,imgProducto,descripcion')
        ->get(['cantidad','idProductoCarrito','fk_idProducto']);

        return (ProductoCarritoResource::collection($productoCarrito))  
        ->additional(['msg' => 'Productos obtenidos Correctamente'])
        ->response()
        ->setStatusCode(202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarProductoCarritoRequest $request)
    {
        return (new ProductoCarritoResource(ProductoCarrito::create($request->all())))
        ->additional(['msg' => 'Producto registrado en el carrito Correctamente'])
        ->response()
        ->setStatusCode(202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getByProducto($producto)
    {
        $productoCarrito = ProductoCarrito::where(['fk_idCarrito'=>auth()->user()->carrito->idCarrito,'fk_idProducto'=>$producto])
        ->with('producto:idProducto,nombre,tipo,precio,imgProducto,descripcion')
        ->firstOrFail(['cantidad','idProductoCarrito','fk_idProducto']);
        
        return (new ProductoCarritoResource($productoCarrito))
        ->additional(['msg' => 'Producto obtenido Correctamente'])
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarProductoCarritoRequest $request, ProductoCarrito $productoCarrito)
    {
        $this->authorize('update', $productoCarrito);

        $productoCarrito->update($request->all());
        return (new ProductoCarritoResource($productoCarrito))
                ->additional(['msg' => 'Producto del carrito actualizado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoCarrito $productoCarrito)
    {
        $this->authorize('delete', $productoCarrito);

        $productoCarrito->delete();
        return (new ProductoCarritoResource($productoCarrito))
                ->additional(['msg' => 'Producto del carrito eliminado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }
}
