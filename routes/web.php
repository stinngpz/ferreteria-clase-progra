<?php
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/hola', function () {
    return ('hola mundo programacion wweb');
});

Route::get('/hola2', function () {
    return view('prueba', [
        'empresa' => 'Ferretería La Bendición24'
    ]);

    
});

Route::resource('productos', ProductoController::class);
Route::get('/', function () {
    return redirect()->route('productos.index');
});


Route::resource('empleados', EmpleadoController::class);
