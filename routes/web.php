<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/empleado', [EmpleadoController::class, 'index'])->name('empleado.index');
Route::resource('empleados', EmpleadoController::class);
