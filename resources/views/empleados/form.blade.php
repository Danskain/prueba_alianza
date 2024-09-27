<!-- resources/views/empleados/form.blade.php -->
<div class="form-group">
    <label for="nombres">Nombres:</label>
    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $empleado->nombres ?? '') }}" required>
</div>
<div class="form-group">
    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $empleado->apellidos ?? '') }}" required>
</div>
<div class="form-group">
    <label for="identificacion">Identificación:</label>
    <input type="number" name="identificacion" class="form-control" value="{{ old('identificacion', $empleado->identificacion ?? '') }}" required>
</div>
<div class="form-group">
    <label for="direccion">Dirección:</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $empleado->direccion ?? '') }}" required>
</div>
<div class="form-group">
    <label for="telefono">Teléfono:</label>
    <input type="number" name="telefono" class="form-control" value="{{ old('telefono', $empleado->telefono ?? '') }}" required>
</div>
<div class="form-group">
    <label for="pais">País:</label>
    <input type="text" name="pais" class="form-control" value="{{ old('pais', $empleado->pais ?? '') }}" required>
</div>
<div class="form-group">
    <label for="ciudad">Ciudad:</label>
    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $empleado->ciudad ?? '') }}" required>
</div>
