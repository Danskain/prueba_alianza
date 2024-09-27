<!-- resources/views/empleados/index.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Lista de Empleados</h1>

<a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">Agregar Empleado</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Identificación</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>Cargos</th>
            <th>Colaboradores Asignados</th>
            <th>Acciones</th> <!-- Nueva columna para acciones -->
        </tr>
    </thead>
    <tbody>
        @foreach($empleados as $empleado)
        <tr>
            <td>{{ $empleado->nombres }}</td>
            <td>{{ $empleado->apellidos }}</td>
            <td>{{ $empleado->identificacion }}</td>
            <td>{{ $empleado->direccion }}</td>
            <td>{{ $empleado->telefono }}</td>
            <td>{{ $empleado->pais }}</td>
            <td>{{ $empleado->ciudad }}</td>
            <td>
                @if($empleado->cargos->isNotEmpty())
                @foreach($empleado->cargos as $cargo)
                <span class="badge bg-primary">{{ $cargo->nombre }}</span>
                @endforeach
                @else
                Sin cargos
                @endif
            </td>
            <td>
                @if($empleado->colaboradores->isNotEmpty())
                <ul>
                    @foreach($empleado->colaboradores as $colaborador)
                    <li>{{ $colaborador->nombres }} {{ $colaborador->apellidos }}</li>
                    @endforeach
                </ul>
                @else
                Sin colaboradores
                @endif
            </td>
            <td>
                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
