<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::withCount('equipos');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('estado') && $request->estado !== 'Todos los estados') {
            $query->where('estado', $request->estado);
        }

        $categorias = $query->latest()->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Activo,Inactivo'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'Esta categoría ya existe',
            'estado.required' => 'Debes seleccionar un estado'
        ]);

        Categoria::create($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría creada exitosamente');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load('equipos');
        return response()->json($categoria);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Activo,Inactivo'
        ]);

        $categoria->update($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->equipos()->count() > 0) {
            return redirect()->route('categorias.index')
                             ->with('error', 'No se puede eliminar porque tiene equipos asociados');
        }

        $categoria->delete();
        
        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría eliminada exitosamente');
    }

    public function cambiarEstado(Categoria $categoria)
    {
        $nuevoEstado = $categoria->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $categoria->update(['estado' => $nuevoEstado]);

        return response()->json([
            'success' => true,
            'estado' => $nuevoEstado
        ]);
    }
}