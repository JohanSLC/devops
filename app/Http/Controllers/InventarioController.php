<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::with('categoria');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $equipos = $query->latest()->paginate(15);
        $categorias = Categoria::where('activo', true)->get();

        return view('inventario.index', compact('equipos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('inventario.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:50|unique:equipos',
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|in:Disponible,En Uso,Mantenimiento,Dado de Baja',
            'fecha_adquisicion' => 'nullable|date',
            'precio_adquisicion' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|max:2048'
        ], [
            'codigo.required' => 'El código es obligatorio',
            'codigo.unique' => 'El código ya existe',
            'nombre.required' => 'El nombre es obligatorio',
            'categoria_id.required' => 'Debe seleccionar una categoría'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('equipos', 'public');
        }

        Equipo::create($data);

        return redirect()->route('inventario.index')
            ->with('success', 'Equipo registrado exitosamente');
    }

    public function show(Equipo $inventario)
    {
        $inventario->load(['categoria', 'movimientos.usuario', 'mantenimientos']);
        return view('inventario.show', compact('inventario'));
    }

    public function edit(Equipo $inventario)
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('inventario.edit', compact('inventario', 'categorias'));
    }

    public function update(Request $request, Equipo $inventario)
    {
        $request->validate([
            'codigo' => 'required|max:50|unique:equipos,codigo,' . $inventario->id,
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|in:Disponible,En Uso,Mantenimiento,Dado de Baja',
            'fecha_adquisicion' => 'nullable|date',
            'precio_adquisicion' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($inventario->foto) {
                Storage::disk('public')->delete($inventario->foto);
            }
            $data['foto'] = $request->file('foto')->store('equipos', 'public');
        }

        $inventario->update($data);

        return redirect()->route('inventario.index')
            ->with('success', 'Equipo actualizado exitosamente');
    }

    public function destroy(Equipo $inventario)
    {
        if ($inventario->foto) {
            Storage::disk('public')->delete($inventario->foto);
        }

        $inventario->delete();

        return redirect()->route('inventario.index')
            ->with('success', 'Equipo eliminado exitosamente');
    }
}