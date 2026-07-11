<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\FormularioCampoController;
use App\Http\Controllers\FormularioPublicoController;
use App\Http\Controllers\FormularioRespuestaController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\ConfiguracionController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware('auth.session','tenant');

Route::get(
    '/empresas',
    [EmpresaController::class, 'index']
)->middleware(['auth.session','superadmin']);

Route::get(
    '/empresas/create',
    [EmpresaController::class, 'create']
)->middleware(['auth.session','superadmin']);

Route::post(
    '/empresas/store',
    [EmpresaController::class, 'store']
)->middleware(['auth.session','superadmin']);

Route::get(
    '/empresas/{id}/edit',
    [EmpresaController::class, 'edit']
)->middleware(['auth.session','superadmin']);

Route::post(
    '/empresas/{id}/delete',
    [EmpresaController::class, 'destroy']
)->middleware(['auth.session','superadmin']);

Route::post(
    '/empresas/{id}/update',
    [EmpresaController::class, 'update']
)->middleware(['auth.session','superadmin']);

Route::get(
    '/usuarios',
    [UsuarioController::class, 'index']
)->middleware([
    'auth.session',
    'tenant'
]);

Route::get(
'/usuarios/create',
[UsuarioController::class,'create']
)
->middleware([
'auth.session',
'tenant',
'role:SuperAdmin,Administrador'
]);

Route::post(
'/usuarios/store',
[UsuarioController::class,'store']
)
->middleware([
'auth.session',
'tenant',
'role:SuperAdmin,Administrador'
]);

Route::get(
'/usuarios/{id}/edit',
[UsuarioController::class,'edit']
)
->middleware([
'auth.session',
'tenant',
'role:SuperAdmin,Administrador'
]);

Route::post(
'/usuarios/{id}/update',
[UsuarioController::class,'update']
)
->middleware([
'auth.session',
'tenant',
'role:SuperAdmin,Administrador'
]);

Route::post(
'/usuarios/{id}/delete',
[UsuarioController::class,'destroy']
)
->middleware([
'auth.session',
'tenant',
'role:SuperAdmin,Administrador'
]);

Route::get(
    '/roles',
    [RoleController::class, 'index']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::get(
    '/roles/create',
    [RoleController::class, 'create']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::post(
    '/roles/store',
    [RoleController::class, 'store']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::get(
    '/roles/{id}/edit',
    [RoleController::class, 'edit']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::post(
    '/roles/{id}/update',
    [RoleController::class, 'update']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::post(
    '/roles/{id}/delete',
    [RoleController::class, 'destroy']
)->middleware([
    'auth.session',
    'superadmin'
]);

Route::get(
    '/actividades',
    [ActividadController::class, 'index']
)->middleware([
    'auth.session',
    'tenant'
]);


Route::get(
    '/actividades/create',
    [ActividadController::class, 'create']
)->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/actividades/store',
    [ActividadController::class, 'store']
)->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::get(
    '/actividades/{id}/edit',
    [ActividadController::class, 'edit']
)->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/actividades/{id}/update',
    [ActividadController::class, 'update']
)->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/actividades/{id}/delete',
    [ActividadController::class, 'destroy']
)->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);

/* FORMULARIOS*/


Route::get(
    '/formularios',
    [FormularioController::class,'index']
)
->middleware([
    'auth.session',
    'tenant'
]);


Route::get(
    '/formularios/create',
    [FormularioController::class,'create']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/formularios/store',
    [FormularioController::class,'store']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


// Visualizar formulario
// IMPORTANTE: va antes de edit/update/delete

Route::get(
    '/formularios/{id}',
    [FormularioController::class,'show']
)
->middleware([
    'auth.session',
    'tenant'
]);


Route::get(
    '/formularios/{id}/edit',
    [FormularioController::class,'edit']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/formularios/{id}/update',
    [FormularioController::class,'update']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


// Activar / Desactivar formulario
// No elimina

Route::post(
    '/formularios/{id}/estado',
    [FormularioController::class,'estado']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);

Route::post(
    '/formularios/{id}/responder',
    [FormularioController::class,'responder']
)
->middleware([
    'auth.session',
    'tenant'
]);

// Ver respuestas del formulario

Route::get(
    '/formularios/{id}/respuestas',
    [FormularioController::class,'respuestas']
)
->middleware([
    'auth.session',
    'tenant'
]);

Route::get(
    '/formularios/{id}/respuestas/exportar',
    [FormularioRespuestaController::class, 'exportar']
)->name('formularios.respuestas.exportar');


// Exportar respuestas a CSV

Route::get(
    '/formularios/{id}/exportar',
    [FormularioController::class,'exportar']
)
->middleware([
    'auth.session',
    'tenant'
]);

Route::get(
    '/formularios/{id}/campos',
    [FormularioCampoController::class,'camposFormulario']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);

Route::post(
    '/formularios/{id}/importar',
    [FormularioRespuestaController::class, 'importar']
)->name('formularios.importar');

/* CAMPOS DEL FORMULARIO*/


Route::get(
    '/formulario-campos',
    [FormularioCampoController::class,'index']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::get(
    '/formulario-campos/create',
    [FormularioCampoController::class,'create']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/formulario-campos/store',
    [FormularioCampoController::class,'store']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::get(
    '/formulario-campos/{id}/edit',
    [FormularioCampoController::class,'edit']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/formulario-campos/{id}/update',
    [FormularioCampoController::class,'update']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);


Route::post(
    '/formulario-campos/{id}/delete',
    [FormularioCampoController::class,'destroy']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);

Route::get(
    '/formulario/{id}',
    [FormularioPublicoController::class,'show']
);


Route::post(
    '/formulario/{id}/respuesta',
    [FormularioPublicoController::class,'store']
);
Route::get(
    '/formularios/{id}/respuestas',
    [FormularioRespuestaController::class,'index']
)
->middleware([
    'auth.session',
    'tenant',
    'role:SuperAdmin,Administrador'
]);

Route::get(
    '/asistencias',
    [AsistenciaController::class,'index']
)
->middleware([
    'auth.session',
    'tenant'
]);

Route::post(
    '/asistencias/{id}/confirmar',
    [AsistenciaController::class, 'confirmar']
)->middleware([
    'auth.session',
    'tenant'
]);

Route::get(
    '/historico',
    [HistoricoController::class,'index']
)
->middleware([
    'auth.session',
    'tenant'
]);

Route::get(
    '/configuracion',
    [ConfiguracionController::class,'index']
)->middleware([
    'auth.session',
    'tenant'
]);

Route::get('/logout', [LoginController::class, 'logout']);
