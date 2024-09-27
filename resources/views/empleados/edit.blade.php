<!-- resources/views/empleados/edit.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Editar Empleado</h1>

<form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Necesario para indicar que es una actualización -->

    <div class="form-group">
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" id="nombres" class="form-control" value="{{ $empleado->nombres }}" required>
    </div>

    <div class="form-group">
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $empleado->apellidos }}" required>
    </div>

    <div class="form-group">
        <label for="identificacion">Identificación:</label>
        <input type="number" name="identificacion" id="identificacion" class="form-control" value="{{ $empleado->identificacion }}" required>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $empleado->direccion }}" required>
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="number" name="telefono" id="telefono" class="form-control" value="{{ $empleado->telefono }}" required>
    </div>

    <div class="form-group">
        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais" class="form-control" value="{{ $empleado->pais }}" required>
    </div>

    <div class="form-group">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ $empleado->ciudad }}" required>
    </div>

    <div class="form-group">
        <label for="cargos">Cargo:</label>
        <select name="cargos[]" id="cargos" class="form-control" multiple required>
            @foreach($cargos as $cargo)
            <option value="{{ $cargo->id }}" {{ $empleado->cargos->contains($cargo->id) ? 'selected' : '' }}>
                {{ $cargo->nombre }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group" id="colaboradorSelect" style="display:none;">
        <label for="colaboradores">Colaboradores:</label>
        <select name="colaboradores[]" id="colaboradores" class="form-control" multiple>
            @foreach($colaboradoresSinJefe as $colaborador)
            <option value="{{ $colaborador->id }}">{{ $colaborador->nombres }} {{ $colaborador->apellidos }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
</form>

<script>
    // Lógica similar para mostrar el select de colaboradores si se selecciona "jefe"
    document.getElementById('cargos').addEventListener('change', function() {
        const colaboradorSelect = document.getElementById('colaboradorSelect');
        colaboradorSelect.style.display = this.value.includes('jefe') ? 'block' : 'none';
    });

    // Inicializa el select de colaboradores al cargar la página
    document.getElementById('cargos').dispatchEvent(new Event('change'));
</script>
@endsection
