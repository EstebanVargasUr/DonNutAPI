<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarProductoRequest;
use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Producto::all();
        return  (new ProductoResource(Producto::all()))
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarProductoRequest $request)
    {
        // Producto::create($request->all());
        // return response()->json([
        //     'res' => true,
        //     'msg' => 'Producto registrado Correctamente'
        // ], 200);
        return (new ProductoResource(Producto::create($request->all())))
                ->additional(['msg' => 'Producto registrado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        // return response()->json([
        //     'res' => true,
        //     'producto' => $producto
        // ], 200);
        return (new ProductoResource($producto))
                ->response()
                ->setStatusCode(202);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarProductoRequest $request, Producto $producto)
    {
        // $producto->update($request->all());
        // return response()->json([
        //     'res' => true,
        //     'msg' => 'Producto actualizado Correctamente'
        // ], 200);
        $producto->update($request->all());
        return (new ProductoResource($producto))
                ->additional(['msg' => 'Producto actualizado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        // $producto->delete();
        // return response()->json([
        //     'res' => true,
        //     'msg' => 'Producto Eliminado Correctamente'
        // ], 200);
        $producto->delete();
        return (new ProductoResource($producto))
                ->additional(['msg' => 'Producto eliminado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }
}
