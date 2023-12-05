<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CalendarioController;
use App\Http\Controllers\Admin\CocinaController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Docente\CursoController as DocenteCursoController;
use App\Http\Controllers\Docente\DocenteController;
use App\Http\Controllers\Estudent\EstudianteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PagosController;
use App\Livewire\Admin\EvaluacionDocente;
use App\Livewire\Docente\Components\NewPregunta;
use App\Livewire\Docente\Components\NewTarea;
use App\Livewire\Docente\Show;
use App\Livewire\Estudiante\CalificarTarea;
use App\Livewire\Estudiante\SubirTarea;
use App\Livewire\Personal\ShowPersonal;
use App\Livewire\Trabajos\ShowPregunta;
use App\Livewire\Trabajos\ShowTarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('Admin')) {
            return redirect()->route('admin.home');
        } elseif (auth()->user()->hasRole('Docente')) {
            return redirect()->route('docente.home');
        } elseif (auth()->user()->hasRole('Estudiante')) {
            return redirect()->route('estudiante.home');
        }
        return redirect()->route('home');
    } else {
        return redirect('login');
    }
});
Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin-estudiantes', [UsersController::class, 'estudiantesAll'])->name('admin.estudinte');
    Route::get('/admin-inscripcions', [UsersController::class, 'formInscripcion'])->name('admin.inscripcion');
    Route::post('/admin-inscripcions/store', [UsersController::class, 'inscripcion'])->name('admin.inscripcion.store');
    Route::get('/show/{id}/estudiante', [UsersController::class, 'showEstudiante'])->name('admin.E.show');
    Route::put('/create-student-{id}-update', [UsersController::class, 'update'])->name('update.estudiantes');
    //Docentes
    Route::get('/admin-docentes', [UsersController::class, 'allDocentes'])->name('admin.docentes');
    Route::post('/create-docentes-store', [UsersController::class, 'store'])->name('store.docentes');
    //Se usa para ambos
    //Route::post('/cambio/{id}/rol', [AdminController::class, 'cambiarRol'])->name('cambio.rol');
    //Route::get('/show/{id}/personal', [AdminController::class, 'showPersonal'])->name('admin.P.show');
    //Route::put('/create-personal-{id}-update', [AdminController::class, 'update'])->name('update.personal');

    Route::get('/show/{id}/docente', Show::class)->name('admin.D.show');
    Route::delete('admin/personal/{id}/{accion}', [UsersController::class, 'gestionarEstadoPersonal'])->name('admin.P.gestionarEstado');
    Route::delete('admin/docente/{id}/{accion}', [UsersController::class, 'gestionarEstadoDocente'])->name('admin.D.gestionarEstado');
    Route::delete('admin/estudiante/{id}/{accion}', [UsersController::class, 'gestionarEstadoEstudiante'])->name('admin.E.gestionarEstado');
    //Personal de la institucion
    Route::get('/admin-users', [AdminController::class, 'allUsers'])->name('admin.users');
    Route::get('/show/{id}/personal', Show::class)->name('admin.P.show');
    Route::post('/personal-new', [AdminController::class, 'store'])->name('admin.personal.store');
    //Personals
    Route::get('/admin-personal', [UsersController::class, 'allPersonal'])->name('admin.personal');
    //Calendario
    Route::get('/calendar', [CalendarioController::class, 'index'])->name('admin.calendario');
    Route::post('/calendar/store', [CalendarioController::class, 'store'])->name('admin.calendario.store');
    Route::post('/calendar/{id}/evento/edit', [CalendarioController::class, 'edit'])->name('admin.calendario.edit');
    Route::post('/calendar/{id}/evento/update', [CalendarioController::class, 'update'])->name('admin.calendario.update');
    Route::post('/calendar/{id}/evento/delete', [CalendarioController::class, 'delete'])->name('admin.calendario.delete');
    Route::get('/calendar/{id}/evento/show', [CalendarioController::class, 'show'])->name('admin.calendario.show');
    //Cursos
    Route::get('/admin-cursos', [CursoController::class, 'index'])->name('admin.cursos');
    Route::post('/curso-info', [CursoController::class, 'guardarCurso'])->name('admin.guardar-curso');
    Route::put('/curso-info/{id}/edit', [CursoController::class, 'actualizarCurso'])->name('admin.actualizar-curso');
    Route::delete('admin/materia/{id}/baja', [CursoController::class, 'darBajaCurso'])->name('admin.cursos.darBaja');
    Route::delete('admin/materia/{id}/alta', [CursoController::class, 'darAltaCurso'])->name('admin.cursos.darAlta');
    Route::get('admin/materia/{id}/delete', [CursoController::class, 'deleteCurso'])->name('admin.cursos.delete');
    Route::get('/asignando-curso/{id}', [CursoController::class, 'asignarCurso'])->name('admin.asignar.curso');
    Route::get('/cursos-curso/meshgv', [CursoController::class, 'cursosActivos'])->name('admin.cursos.activos');
    Route::get('admin/show/{id}', [CursoController::class, 'showCurso'])->name('admin.cursos.show');
    Route::post('/curso-info/asignar', [CursoController::class, 'asignarGuardarCurso'])->name('admin.asignar.guardar.curso');
    Route::put('/curso-info/{id}/edit/asignar', [CursoController::class, 'asignarActualizarCurso'])->name('admin.asignar.actualizar-curso');
    Route::get('/asignados/cursos/{id}/edit', [CursoController::class, 'editCursoAsignado'])->name('admin.asigando.edit');
    Route::post('/asignados/cambiar/{id}', [CursoController::class, 'gestionarEstadoCurso'])->name('admin.cursos.cambiarEstado');
    Route::get('/borrar/cambiar-estado/{id}', [CursoController::class, 'deleteCursoActivo'])->name('admin.borrar.curso.activo');
    Route::get('/cursos/{id}', [CursoController::class, 'show']);
    Route::get('/curso/programdo/yoy/{id}/{estud}', [CursoController::class, 'programarCurso'])->name('curso.programado');

    ///pagos
    Route::get('/admin-pagos-all', [PagosController::class, 'allPagos'])->name('admin.lista.pagos');
    Route::post('/pagos/guardars', [PagosController::class, 'guardarPago'])->name('admin.pago.guardar');
    Route::get('/pagos/guadar/imprimir', [PagosController::class, 'guardarImprimirPago'])->name('admin.pago.guardar.imprimir');
    //Cocina
    //Acerda de IGLA
    Route::get('/informacion', [HomeController::class, 'acercaDe'])->name('admin.ajustes');
    Route::post('/guardar-info', [InformacionController::class, 'guardarInformacion'])->name('admin.guardar-registro');
    Route::put('/actualizar-info/{id}', [InformacionController::class, 'actualizarInformacion'])->name('admin.actualizar-registro');
    //Administracion de informacion
    Route::get('/administrar-info', [InformacionController::class, 'adminstrarInfo'])->name('admin.administracion');
    Route::post('/administrar-aula-add', [InformacionController::class, 'storeAula'])->name('admin.guardar-aula');
    Route::put('/administrar-aula/{id}/edit', [InformacionController::class, 'updateAula'])->name('admin.actualizar-aula');
    Route::post('/administrar-modalidad-add', [InformacionController::class, 'storeModalidad'])->name('admin.guardar-modalidad');
    Route::put('/administrar-modalidad/{id}/edit', [InformacionController::class, 'updateModalidad'])->name('admin.actualizar-modalidad');
    Route::post('/administrar-horario-add', [InformacionController::class, 'storeHorario'])->name('admin.guardar-horario');
    Route::put('/administrar-horario/{id}/edit', [InformacionController::class, 'updateHorario'])->name('admin.actualizar-horario');
    //Evaluacion docente
    Route::get('/evaluacion/add/docente', EvaluacionDocente::class)->name('evaluacion.docente');
});

Route::middleware(['auth', 'role:Docente'])->group(function () {
    Route::get('/chef-dashboard', [DocenteController::class, 'index'])->name('docente.home');
    Route::get('/pregunta/nueva/post/{id}', NewPregunta::class)->name('nueva.pregunta.docente');
    Route::get('/trabajo/nueva/post/{id}', NewTarea::class)->name('nueva.tarea.docente');
    Route::get('/calificando/tarea/{id}', CalificarTarea::class)->name('calificar.tarea.estudiante');
});
Route::middleware(['auth', 'role:Estudiante'])->group(function () {
    Route::get('/estud-dashboard', [EstudianteController::class, 'index'])->name('estudiante.home');
    Route::get('/cursos/carrera/bamos', [EstudianteController::class, 'cursos'])->name('cursos.carrera');
    Route::get('/estud-submit/{id}/{edit}/editar', SubirTarea::class)->name('estudiante.subir.tarea');
});

Route::middleware(['auth'])->group(function () {
    //calendario
    Route::get('/calendar/mostrar', [CalendarioController::class, 'mostrar'])->name('admin.calendario.ver');
    //cocina Ingredientes
    Route::get('/ingretientes-all', [CocinaController::class, 'allIngredientes'])->name('admin.ingredientes');
    Route::get('/recetas-all/dsgsa', [CocinaController::class, 'allrecetas'])->name('admin.recetas');

    //Route::put('/reset/{id}/pass/est', [EstudianteController::class, 'cambiarPass'])->name('cambiar.password.E');
    //Route::put('/reset/{id}/pass/dc', [ChefsController::class, 'cambiarPass'])->name('cambiar.password.Chef');
    //Route::put('/reset/{id}/pass/pers', [AdminController::class, 'cambiarPass'])->name('cambiar.password.Admin');
    //Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    
    //Cursos
    Route::get('/cursos', [DocenteCursoController::class, 'index'])->name('chef.cursos');
    Route::get('/curso/{id}/materia', [DocenteCursoController::class, 'curso'])->name('cursos.curso');
    //Componetes
    Route::get('/posts-pregunta/{id}', ShowPregunta::class)->name('show.pregunta');
    Route::get('/posts-tareas/{id}', ShowTarea::class)->name('show.tarea');
});
