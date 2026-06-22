<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;

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

Route::get(
    '/usuarios/create',
    [UsuarioController::class, 'create']
)->middleware('auth.session');

Route::post(
    '/usuarios/store',
    [UsuarioController::class, 'store']
)->middleware('auth.session');

Route::get(
    '/usuarios/{id}/edit',
    [UsuarioController::class, 'edit']
)->middleware('auth.session');

Route::post(
    '/usuarios/{id}/update',
    [UsuarioController::class, 'update']
)->middleware('auth.session');

Route::get(
    '/roles',
    [RoleController::class, 'index']
)->middleware('auth.session');

Route::get(
    '/roles/create',
    [RoleController::class, 'create']
)->middleware('auth.session');

Route::post(
    '/roles/store',
    [RoleController::class, 'store']
)->middleware('auth.session');


Route::get(
    '/roles/{id}/edit',
    [RoleController::class, 'edit']
)->middleware('auth.session');

Route::post(
    '/roles/{id}/update',
    [RoleController::class, 'update']
)->middleware('auth.session');

Route::post(
    '/roles/{id}/delete',
    [RoleController::class, 'destroy']
)->middleware('auth.session');

Route::post(
    '/usuarios/{id}/delete',
    [UsuarioController::class, 'destroy']
)->middleware('auth.session');

Route::get('/logout', [LoginController::class, 'logout']);
