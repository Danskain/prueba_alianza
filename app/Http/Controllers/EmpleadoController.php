<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Método para mostrar la lista de empleados
    public function index()
    {
        $empleados = Empleado::with(['colaboradores', 'cargos'])->get();
        return view('empleados.index', compact('empleados'));
    }

    // Método para mostrar el formulario de creación de empleado
    public function create()
    {
        // Paginación de cargos, 10 por página
        $cargos = Cargo::paginate(10);

        // Obtener colaboradores sin jefe
        $colaboradoresSinJefe = Empleado::whereNull('jefe_id')->get();

        return view('empleados.create', compact('cargos', 'colaboradoresSinJefe'));
    }

    // Método para almacenar un nuevo empleado
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'identificacion' => 'required|integer|unique:empleados',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'pais' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'cargo' => 'required|array',
            //'cargo.*' => 'exists:cargos,nombre', // Validar que los cargos existan
            'colaboradores' => 'nullable|array',
            'colaboradores.*' => 'exists:empleados,id', // Validar que los colaboradores existan
        ]);

        // Crear empleado
        $empleado = Empleado::create($request->all());

        // Asociar cargos
        $empleado->cargos()->attach($request->cargo);

        // Si es jefe, asignar colaboradores
        if (in_array('jefe', $request->cargo)) {
            $empleadosSinJefe = Empleado::whereNull('jefe_id')->get();
            foreach ($request->colaboradores as $colaboradorId) {
                $colaborador = Empleado::find($colaboradorId);
                if ($colaborador) {
                    $colaborador->jefe_id = $empleado->id; // Asignar el jefe al colaborador
                    $colaborador->save();
                }
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    // Método para mostrar el formulario de edición de empleado
    public function edit(Empleado $empleado)
    {
        $cargos = Cargo::all(); // Cargar todos los cargos
        $colaboradoresSinJefe = Empleado::whereNull('jefe_id')->get(); // Obtener colaboradores sin jefe
        return view('empleados.edit', compact('empleado', 'cargos', 'colaboradoresSinJefe'));
    }

    // Método para actualizar un empleado
    public function update(Request $request, Empleado $empleado)
    {
        // Validar los datos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'identificacion' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'pais' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'cargos' => 'required|array',
            'cargos.*' => 'exists:cargos,id', // Verifica que los cargos existen
            'colaboradores' => 'array', // Si se seleccionan colaboradores
            'colaboradores.*' => 'exists:empleados,id', // Verifica que los colaboradores existen
        ]);

        // Actualizar el empleado
        $empleado->update($request->except('cargos', 'colaboradores'));

        // Sincronizar cargos
        $empleado->cargos()->sync($request->input('cargos'));

        // Limpiar la relación con colaboradores anteriores
        Empleado::where('jefe_id', $empleado->id)->update(['jefe_id' => null]);

        // Si es jefe, asignar colaboradores
        if (in_array('jefe', $request->input('cargos'))) {
            foreach ($request->input('colaboradores', []) as $colaboradorId) {
                $colaborador = Empleado::find($colaboradorId);
                $colaborador->jefe_id = $empleado->id;
                $colaborador->save();
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    // Método para eliminar un empleado
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
