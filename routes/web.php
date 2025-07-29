<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsersController;
use PHPUnit\Framework\TestStatus\Risky;

Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_post'])->name('login_post');
Route::post('registration_post', [AuthController::class, 'registration_post'])->name('registration_post');
Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth', 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
});
Route::group(['middleware' => 'auth', 'cocina'], function () {
    Route::get('cocina/dashboard', [DashboardController::class, 'dashboard'])->name('cocina.dashboard');
});
Route::group(['middleware' => 'auth', 'mesero'], function () {
    Route::get('mesero/dashboard', [DashboardController::class, 'dashboard'])->name('mesero.dashboard');
});

// Rutas principales de comandas
Route::controller(ComandaController::class)->group(function () {
    // CRUD básico
    Route::get('/comandas', 'index')->name('comandas.index');
    Route::get('/comandas/create', 'create')->name('comandas.create');
    Route::post('/comandas', 'store')->name('comandas.store');
    Route::get('/comandas/{comanda}/edit', 'edit')->name('comandas.edit');
    Route::put('/comandas/{comanda}', 'update')->name('comandas.update');
    Route::delete('/comandas/{comanda}', 'destroy')->name('comandas.destroy');
    Route::put('/comandas/{comanda}/producto/{producto}/estado', 'marcarProductoPreparado')->name('comandas.producto.estado');

    // Gestión de estados
    Route::prefix('/comandas/{comanda}')->group(function () {
        Route::put('/entregar', 'entregar')->name('comandas.entregar');
        Route::put('/estado', 'cambiarEstado')->name('comandas.cambiarEstado');
    });

    // Vista especial de cocina
    Route::get('/cocina', 'vistaCocina')->name('comandas.vistaCocina');
    //Cuenta
    Route::post('/comandas/{comanda}/cuenta', [ComandaController::class, 'generarCuenta'])->name('comandas.generarCuenta');
});
//productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

//Reportes
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
/* Route::get('/reportes/exportar', [ReporteController::class, 'exportar'])->name('reportes.exportar'); */
//users
Route::get('/usuarios/registro', [AuthController::class, 'registration'])->name('registration');
Route::post('/usuarios/registro', [AuthController::class, 'registration_post'])->name('registration_post');
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.view');
Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');


