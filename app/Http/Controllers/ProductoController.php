<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('crud.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$producto = Producto::create($request->validated());
        return response()->json([
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
        ]); */

        // Validar los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        // Crear el nuevo producto
        $producto = Producto::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ]);

        // Si todo sale bien, devolver respuesta JSON
        return response()->json([
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'id' => $producto->id,
            'cont' => Producto::count()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        // Encontrar el producto y actualizar
        $producto = Producto::findOrFail($id);
        $producto->update($validated);

        // Devolver respuesta en formato JSON
        return response()->json([
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrar el producto y eliminar
        $producto = Producto::findOrFail($id);
        $producto->delete();

        // Devolver respuesta de éxito
        return response()->json(['success' => true]);
    }
}
