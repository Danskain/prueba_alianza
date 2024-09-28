<!-- @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif -->
@extends('layouts.app')

@section('content')
<h1>{{ isset($empleado) ? 'Editar' : 'Crear' }} Empleado</h1>

<form action="{{ isset($empleado) ? route('empleados.update', $empleado) : route('empleados.store') }}" method="POST">
    @csrf
    @if(isset($empleado))
    @method('PUT')
    @endif

    <!-- Campos de empleado -->
    <div class="form-group">
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $empleado->nombres ?? '') }}">
    </div>

    <div class="form-group">
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $empleado->apellidos ?? '') }}">
    </div>

    <div class="form-group">
        <label for="identificacion">Identificación:</label>
        <input type="text" name="identificacion" class="form-control" value="{{ old('identificacion', $empleado->identificacion ?? '') }}">
    </div>

    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $empleado->direccion ?? '') }}">
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $empleado->telefono ?? '') }}">
    </div>

    <!-- <div class="form-group">
        <label for="pais">País:</label>
        <input type="text" name="pais" class="form-control" value="{{ old('pais', $empleado->pais ?? '') }}">
    </div> -->

    <!-- Select para País -->
    <div class="form-group">
        <label for="pais">País:</label>
        <select name="pais" id="pais" class="form-control" value="{{ old('pais', $empleado->pais ?? '') }}">
            <option value="">Seleccione un país</option>
            <!-- Opciones se cargarán dinámicamente -->
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $empleado->ciudad ?? '') }}">
    </div> -->

    <!-- Select para Ciudad -->
    <div class="form-group">
        <label for="ciudad">Ciudad:</label>
        <select name="ciudad" id="ciudad" class="form-control" value="{{ old('ciudad', $empleado->ciudad ?? '') }}">
            <option value="">Seleccione una ciudad</option>
            <!-- Opciones se cargarán dinámicamente -->
        </select>
    </div>

    <!-- Select para elegir el cargo -->
    <div class="form-group">
        <label for="cargo">Cargo:</label>
        <select name="cargo[]" id="cargo" class="form-control" multiple>
            @foreach($cargos as $cargo)
            <option value="{{ $cargo->id }}"
                {{ isset($empleado) && $empleado->cargos->contains('nombre', $cargo->nombre) ? 'selected' : '' }}>
                {{ $cargo->nombre }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- Select para asignar Colaboradores -->
    <div class="form-group" id="colaboradores-section" style="display: none;">
        <label for="colaboradores">Colaboradores:</label>
        <select name="colaboradores[]" id="colaboradores" class="form-control" multiple>
            @foreach($colaboradoresSinJefe as $colaborador)
            <option value="{{ $colaborador->id }}">
                {{ $colaborador->nombres }} {{ $colaborador->apellidos }}
            </option>
            @endforeach
        </select>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Botón para Guardar -->
    <button type="submit" class="btn btn-primary">{{ isset($empleado) ? 'Actualizar' : 'Guardar' }}</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const paisSelect = document.getElementById('pais');
        const ciudadSelect = document.getElementById('ciudad');

        // Cargar los países al cargar la página
        fetch('https://countriesnow.space/api/v0.1/countries')
            .then(response => response.json())
            .then(data => {
                data.data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.country;
                    option.textContent = country.country;
                    paisSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar los países:', error));

        // Cargar las ciudades cuando se selecciona un país
        paisSelect.addEventListener('change', function() {
            const selectedCountry = paisSelect.value;
            ciudadSelect.innerHTML = '<option value="">Seleccione una ciudad</option>'; // Limpiar las ciudades previas

            if (selectedCountry) {
                fetch('https://countriesnow.space/api/v0.1/countries/cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            country: selectedCountry
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            ciudadSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar las ciudades:', error));
            }
        });


        ////////////////////////////////////////////////////////////////
        const cargoSelect = document.getElementById('cargo');
        const colaboradoresSection = document.getElementById('colaboradores-section');

        function toggleColaboradores() {
            if (Array.from(cargoSelect.selectedOptions).some(option => option.value === '2')) {
                colaboradoresSection.style.display = 'block';
            } else {
                colaboradoresSection.style.display = 'none';
            }
        }

        cargoSelect.addEventListener('change', toggleColaboradores);
        toggleColaboradores(); // Ejecutar al cargar la página por si hay selección previa
    });
</script>
@endsection
