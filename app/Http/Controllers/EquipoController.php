<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::with('categoria');

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('modelo', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $equipos = $query->latest()->paginate(10);
        $categorias = Categoria::orderBy('nombre')->get();

        return view('inventario.index', compact('equipos', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:equipos,codigo|max:50',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'nullable|max:100',
            'modelo' => 'nullable|max:100',
            'serie' => 'nullable|max:100',
            'estado' => 'required|in:Disponible,En Uso,Mantenimiento,Dado de Baja',
            'fecha_adquisicion' => 'nullable|date',
            'precio_adquisicion' => 'nullable|numeric|min:0',
            'ubicacion' => 'nullable|max:255',
            'observaciones' => 'nullable',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('equipos', 'public');
        }

        Equipo::create($validated);

        return redirect()->route('inventario.index')->with('success', 'Equipo registrado exitosamente');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load('categoria', 'movimientos', 'mantenimientos');
        return response()->json($equipo);
    }

    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'codigo' => 'required|max:50|unique:equipos,codigo,' . $equipo->id,
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'nullable|max:100',
            'modelo' => 'nullable|max:100',
            'serie' => 'nullable|max:100',
            'estado' => 'required|in:Disponible,En Uso,Mantenimiento,Dado de Baja',
            'fecha_adquisicion' => 'nullable|date',
            'precio_adquisicion' => 'nullable|numeric|min:0',
            'ubicacion' => 'nullable|max:255',
            'observaciones' => 'nullable',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($equipo->foto) {
                Storage::disk('public')->delete($equipo->foto);
            }
            $validated['foto'] = $request->file('foto')->store('equipos', 'public');
        }

        $equipo->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Equipo actualizado exitosamente');
    }

    public function destroy(Equipo $equipo)
    {
        if ($equipo->foto) {
            Storage::disk('public')->delete($equipo->foto);
        }
        
        $equipo->delete();

        return redirect()->route('inventario.index')->with('success', 'Equipo eliminado exitosamente');
    }
}