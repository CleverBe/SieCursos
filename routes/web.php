<?php

use App\Http\Controllers\ExportCursosPdfController;
use App\Http\Controllers\ExportPagosController;
use App\Http\Livewire\AreasCursosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\AulasController;
use App\Http\Livewire\CalificarController;
use App\Http\Livewire\CursosController;
use App\Http\Livewire\HorariosController;
use App\Http\Livewire\InicioAulasController;
use App\Http\Livewire\InicioCursoController;
use App\Http\Livewire\InscripcionesController;
use App\Http\Livewire\ListaController;
use App\Http\Livewire\MiPlanDePagosController;
use App\Http\Livewire\NotasEstudianteController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\UsuariosController;
use App\Http\Livewire\ReporteCursosController;
use App\Http\Livewire\ReportePagosController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\SolicitudController;
use App\Http\Livewire\SolicitudesPagosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', UsuariosController::class)->name('usuarios')->middleware('permission:ver_usuarios');
    Route::get('/aulas', AulasController::class)->name('aulas')->middleware('permission:ver_aulas');
    Route::get('/areasCursos', AreasCursosController::class)->name('areasCursos')->middleware('permission:ver_areas');
    Route::get('/cursos', CursosController::class)->name('cursos')->middleware('permission:ver_cursos');
    Route::get('/horarios', HorariosController::class)->name('horarios')->middleware('permission:ver_horarios');
    Route::get('/inscripciones/{horario_id}', InscripcionesController::class)->name('inscripciones')->middleware('permission:ver_inscripciones');
    Route::get('/solicitudesPagos', SolicitudesPagosController::class)->name('solicitudesPagos')->middleware('permission:ver_solicitudes');
    Route::get('/solicitud/{solicitud_id}', SolicitudController::class)->name('solicitud')->middleware('permission:ver_solicitud');
    Route::get('/reportesCursos', ReporteCursosController::class)->name('reportesCursos')->middleware('permission:ver_report_Estudiantes');
    Route::get('/reportesPagos', ReportePagosController::class)->name('reportesPagos')->middleware('permission:ver_report_Pagos');

    Route::group(['middleware' => ['permission:export_report_Estudiantes']], function () {
        Route::get('reporteCursos/pdf/{periodoFiltro}/{cursoFiltro}/{horarioFiltro}', [ExportCursosPdfController::class, 'reporte']);
        Route::get('reporteCursos/pdf/{periodoFiltro}/{cursoFiltro}', [ExportCursosPdfController::class, 'reporte']);
        Route::get('reporteCursos/pdf/{periodoFiltro}', [ExportCursosPdfController::class, 'reporte']);
    });
    Route::group(['middleware' => ['permission:export_report_Pagos']], function () {
        Route::get('reportePagos/pdf/{periodoFiltro}/{reportType}/{dateFrom}/{dateTo}/{cursoFiltro}/{horarioFiltro}', [ExportPagosController::class, 'reporte']);
        Route::get('reportePagos/pdf/{periodoFiltro}/{reportType}/{dateFrom}/{dateTo}/{cursoFiltro}', [ExportPagosController::class, 'reporte']);
        Route::get('reportePagos/pdf/{periodoFiltro}/{reportType}/{dateFrom}/{dateTo}', [ExportPagosController::class, 'reporte']);
    });
    Route::group(['middleware' => ['role:ADMIN']], function () {
        Route::get('/permisos', PermisosController::class)->name('permisos');
        Route::get('/roles', RolesController::class)->name('roles');
        Route::get('/asignar', AsignarController::class)->name('asignar');
    });

    Route::get('/inicioAulas', InicioAulasController::class)->name('inicioAulas')->middleware('permission:ver_inicio_aulas');
    Route::get('/cursos/{horario_id}', InicioCursoController::class)->name('cursos')->middleware('permission:ver_inicio_curso');
    Route::get('/calificar/{horario_id}', CalificarController::class)->name('calificar')->middleware('permission:ver_calificar');
    Route::get('/lista/{horario_id}', ListaController::class)->name('lista')->middleware('permission:ver_lista');
    Route::get('/misPagos/{horario_id}', MiPlanDePagosController::class)->name('misPagos')->middleware('permission:ver_mis_pagos');
    Route::get('/misNotas/{horario_id}', NotasEstudianteController::class)->name('misNotas')->middleware('permission:ver_mis_notas');
});
