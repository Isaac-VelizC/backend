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
use App\Http\Controllers\BackupController;
use App\Http\Controllers\InfoController;
use App\Livewire\Admin\AdminInfo;
use App\Livewire\Admin\EvaluacionDocente;
use App\Livewire\Admin\FormPagos;
use App\Livewire\Admin\Informe\AsistenciaReportes;
use App\Livewire\Admin\Informe\EstudianteReportes;
use App\Livewire\Admin\Informe\MateriaReportes;
use App\Livewire\Admin\Informe\PagosReportes;
use App\Livewire\Admin\MateriaEvaluacionDocente;
use App\Livewire\Docente\CriteriosTrabajos;
use App\Livewire\Docente\NewReceta;
use App\Livewire\Docente\Show;
use App\Livewire\Estudiante\CalificarTarea;
use App\Livewire\Estudiante\SubirTarea;
use App\Livewire\ProfilePage;
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
    Route::get('/backup', [BackupController::class, 'downloadBackup'])->name('admin.backup.db_igla');
    Route::get('/admin-estudiantes', [UsersController::class, 'estudiantesAll'])->name('admin.estudinte');
    Route::get('/admin-inscripcions', [UsersController::class, 'formInscripcion'])->name('admin.inscripcion');
    Route::post('/admin-inscripcions/store', [UsersController::class, 'inscripcion'])->name('admin.inscripcion.store');
    Route::get('/show/{id}/estudiante', [UsersController::class, 'showEstudiante'])->name('admin.E.show');
    Route::put('/create-student-{id}-update', [UsersController::class, 'update'])->name('update.estudiantes');
    Route::post('/selectEstudi',[UsersController::class, 'selectEstudiante'])->name('search.estudiantes');
    //Docentes
    Route::get('/admin-docentes', [UsersController::class, 'allDocentes'])->name('admin.docentes');
    Route::post('/create-docentes-store', [UsersController::class, 'store'])->name('store.docentes');
    //Se usa para ambos
    //Route::post('/cambio/{id}/rol', [AdminController::class, 'cambiarRol'])->name('cambio.rol');

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
    ///pagos
    Route::get('/admin-pagos-all', [PagosController::class, 'allPagos'])->name('admin.lista.pagos');
    Route::get('/pagos/formulario/hjfse', FormPagos::class)->name('admin.create.pago');
    Route::get('/pagos/guadar/imprimir', [PagosController::class, 'guardarImprimirPago'])->name('admin.pago.guardar.imprimir');
    //Cocina
    //Acerda de IGLA
    Route::get('/informacion', [HomeController::class, 'acercaDe'])->name('admin.ajustes');
    //Administracion de informacion
    Route::get('/administrar-info', AdminInfo::class)->name('admin.administracion');
    //Evaluacion docente
    Route::get('/evaluacion/add/docente', EvaluacionDocente::class)->name('evaluacion.docente');
    Route::get('/evaluacion/listado/docente', MateriaEvaluacionDocente::class)->name('materia.evaluacion.docente');
    //Rutas para exportar
    Route::get('/cursos/exp/pdf', [CursoController::class, 'exportarCurso'])->name('export.cursos');
    //Rutasp para reportes
    Route::get('/estudiantes/reporte/export', EstudianteReportes::class)->name('admin.estudiantes.informe');
    Route::get('/asistencias/reporte/export', AsistenciaReportes::class)->name('admin.asistencias.informe');
    Route::get('/materias/reporte/export', MateriaReportes::class)->name('admin.materias.informe');
    Route::get('/pagos/reporte/export', PagosReportes::class)->name('admin.pagos.informe');
});

Route::middleware(['auth', 'role:Docente'])->group(function () {
    Route::get('/chef-dashboard', [DocenteController::class, 'index'])->name('docente.home');
    //Route::get('/trabajo/nueva/post/{id}', NewTarea::class)->name('nueva.tarea.docente');
    Route::get('/trabajo/nueva/post/{id}', [DocenteCursoController::class, 'createTareaNew'])->name('nueva.tarea.docente');
    Route::post('/trabajo/tarea/new', [DocenteCursoController::class, 'crearTarea'])->name('guardar.tarea.new');
    //Route::post('/crear/tarea', [DocenteCursoController::class, 'tareaAutomatico'])->name('crear.tarea.automatico');
    Route::get('/calificando/tarea/{id}', CalificarTarea::class)->name('calificar.tarea.estudiante');
    Route::post('/planificacion/curso/{id}', [DocenteController::class, 'planificacion'])->name('guardar.planificacion');
    Route::get('/criterios/tareas/{id}/eval', CriteriosTrabajos::class)->name('docente.tareas.criterios');
    Route::post('/selectReceta',[DocenteCursoController::class, 'selectReceta'])->name('search.recetas');
});
Route::middleware(['auth', 'role:Estudiante'])->group(function () {
    Route::get('/calendar/mostrar/trabajos', [CalendarioController::class, 'mostrarTrabajos'])->name('admin.calendario.trabajos');
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
    Route::get('/recetas-show/{id}', [CocinaController::class, 'showReceta'])->name('admin.show.receta');
    Route::delete('/recetas-eliminar/{id}', [CocinaController::class, 'deleteReceta'])->name('admin.receta.eliminar');
    Route::post('/select',[CocinaController::class, 'selectIngredientes'])->name('search.ingredientes');
    Route::post('/admin/buscar-ingredientes', [CocinaController::class, 'buscarIngredientes'])->name('admin.buscar-ingredientes');
    Route::get('/agregar-receta/nueva', NewReceta::class)->name('recetas.add');
    Route::get('/profile', ProfilePage::class)->name('users.profile');
    //Cursos
    Route::get('/cursos', [DocenteCursoController::class, 'index'])->name('chef.cursos');
    Route::get('/curso/{id}/materia', [DocenteCursoController::class, 'curso'])->name('cursos.curso');
    //Componetes
    Route::get('/posts-tareas/{id}', ShowTarea::class)->name('show.tarea');
    //notificaciones
    Route::get('/send-whatsapp', [InfoController::class, 'sendWhatsAppMessage']);
});
