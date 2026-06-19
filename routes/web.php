<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware('auth.session');

Route::get(
    '/empresas',
    [EmpresaController::class, 'index']
)->middleware('auth.session');

Route::get(
    '/usuarios',
    [UsuarioController::class, 'index']
)->middleware('auth.session');

Route::get('/logout', [LoginController::class, 'logout']);
