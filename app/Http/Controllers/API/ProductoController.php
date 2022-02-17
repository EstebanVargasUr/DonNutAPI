<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show','getByTipo']]);
    }

    public function index()
    {
        return  (ProductoResource::collection(Producto::all()))
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
        $this->authorize('create', Producto::class);
        
        $producto = new Producto($request->all());
        
        if($request->imgBanner){
            $path = $request->imgBanner->store('public/images/banners');
            $producto->imgBanner = str_replace("public", "/storage", $path);
        }

        $path = $request->imgProducto->store('public/images/productos');
        $producto->imgProducto = str_replace("public", "/storage", $path);
        $producto->save();

        return (new ProductoResource($producto))
                ->additional(['msg' => 'Producto registrado Correctamente'])
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return (new ProductoResource($producto))
                ->response()
                ->setStatusCode(202);
    }

    public function getByTipo($tipoProducto)
    {
        return (ProductoResource::collection(Producto::where('tipo',$tipoProducto)->get()))
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
    public function update(ActualizarProductoRequest $request, Producto $producto)
    {   
        $this->authorize('update', $producto);

        if($request->imgBanner){
            $path = $request->imgBanner->store('public/images/banners');
            if($producto->imgBanner != '/storage/images/default.svg')
            Storage::delete(str_replace("storage", "public", $producto->imgBanner));
            $producto->imgBanner = str_replace("public", "/storage", $path);
            $producto->save();
        }

        if($request->imgProducto){
            if(Storage::exists(str_replace("storage", "public", $producto->imgProducto))){
                Storage::delete(str_replace("storage", "public", $producto->imgProducto));
            }
            $path = $request->imgProducto->store('public/images/productos');
            $producto->imgProducto = str_replace("public", "/storage", $path);
            $producto->save();
        }

        $producto->update($request->except(['imgProducto','imgBanner']));

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
        $this->authorize('delete', $producto);

        $producto->delete();
        return (new ProductoResource($producto))
                ->additional(['msg' => 'Producto eliminado Correctamente'])
                ->response()
                ->setStatusCode(202);
    }
}
