<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CalendarioController;
use App\Http\Controllers\Admin\CocinaController;
use App\Http\Controllers\Admin\CriterioController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Docente\CursoController as DocenteCursoController;
use App\Http\Controllers\Docente\DocenteController;
use App\Http\Controllers\Estudent\EstudianteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PagosController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Docente\RecetaController;
use App\Http\Controllers\InfoController;
use App\Livewire\Admin\AdminInfo;
use App\Livewire\Admin\EvaluacionDocente;
use App\Livewire\Admin\GestionPermisos;
use App\Livewire\Admin\HistorialEvaluacionDocente;
use App\Livewire\Admin\HistorialInventario;
use App\Livewire\Admin\Informe\MateriaReportes;
use App\Livewire\Docente\NewReceta;
use App\Livewire\Docente\Show;
use App\Livewire\Estudiante\SubirTarea;
use App\Livewire\ProfilePage;
use App\Livewire\Trabajos\ShowTarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        switch (auth()->user()->role) {
            case 'Admin':
            case 'Secretario/a':
                return redirect()->route('admin.home');
            case 'Docente':
                return redirect()->route('docente.home');
            case 'Estudiante':
                return redirect()->route('estudiante.home');
            default:
                return redirect()->route('home');
        }
    } else {
        return redirect('login');
    }
});

Route::middleware('throttle:login')->group(function () {
    Auth::routes(['register' => false]);
});

Route::get('generar/receta.ai', [InfoController::class, 'generateAIReceta'])->name('generate.ai.receta');
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:Admin|Secretario/a', 'inactivity:20'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/gestionar/permisos/admin', GestionPermisos::class)->name('admin.gestion.permisos');
    
    Route::get('/backups', [BackupController::class, 'listBackups'])->name('backup.list');
    Route::get('/backups/download/{file}', [BackupController::class, 'downloadBackup'])->name('backup.download');
    Route::post('/backups/run', [BackupController::class, 'runBackup'])->name('backup.run');
    Route::get('/backup/delete/{name}', [BackupController::class, 'deleteBackup'])->name('backup.delete');
    
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
    Route::get('/ruta/del/server/para/obtener/disponibilidad', [CursoController::class, 'obtenerDisponibilidad']);
    Route::get('/ruta/al/servidor/para/obtener/cursos', [CursoController::class, 'obtenerCursosAnteriores']);
    ///Programar Materias
    Route::get('/programar/materia/estudiantes/{id}', [CursoController::class, 'pageProgramarEstudiantes'])->name('programar.materia');
    Route::post('/save/materia/estudiantes', [CursoController::class, 'programarEstudiantesMateria'])->name('save.programar.materia');
    ///pagos
    Route::get('/admin-pagos-all', [PagosController::class, 'allPagos'])->name('admin.lista.pagos');
    Route::get('/pagos/formulario/hjfse', [PagosController::class, 'formPagos'])->name('admin.create.pago');
    Route::post('/pagos/store', [PagosController::class, 'storePagosSimples'])->name('admin.store.pago');
    Route::get('/pagos/guadar/imprimir/{id}', [PagosController::class, 'guardarImprimirPago'])->name('admin.pago.guardar.imprimir');
    Route::get('/pagos/habilitar/mes', [PagosController::class, 'habilitarPagosMes'])->name('admin.habiltar.pagos.mes');
    Route::get('/obtener/detalles/pago/{id}', [PagosController::class, 'obtenerDetallesPago'])->name('admin.pagos.detalle');
    Route::get('/obtener/historial/pago', [PagosController::class, 'historialPago'])->name('admin.pagos.historial');
    Route::get('/edit/pago/{id}', [PagosController::class, 'editPage'])->name('admin.pagos.edit');
    Route::put('/pagos/update/{id}', [PagosController::class, 'updatePago'])->name('admin.update.pago');
    //Cocina
    //Acerda de IGLA
    Route::get('/informacion', [HomeController::class, 'acercaDe'])->name('admin.ajustes');
    //Administracion de informacion
    Route::get('/administrar-info', AdminInfo::class)->name('admin.administracion');
    //Evaluacion docente
    Route::get('/evaluacion/add/docente', EvaluacionDocente::class)->name('evaluacion.docente');
    Route::get('/evaluacion/listado/docente', [CursoController::class, 'HabilitarEvaluacionDocenteMateria'])->name('materia.evaluacion.docente');
    Route::post('/evaluacion/habilitar/docente', [CursoController::class, 'habilitarEvaluacion'])->name('materia.evaluacion.docente.habilitar');
    Route::post('/evaluacion/deshabilitar/docente', [CursoController::class, 'borrarEvaluacion'])->name('materia.evaluacion.docente.quitar');
    //Route::get('/evaluacion/listado/docente', MateriaEvaluacionDocente::class)->name('materia.evaluacion.docente');
    Route::get('/evaluacion/historial/docente', HistorialEvaluacionDocente::class)->name('historial.evaluacion.docente');
    //Rutas para exportar
    Route::get('/cursos/exp/pdf', [CursoController::class, 'exportarCurso'])->name('export.cursos');
    //Rutasp para reportes
    Route::get('/estudiantes/reporte/export', [ReportsController::class, 'reportsEstudents'])->name('admin.estudiantes.informe');
    Route::post('/estudiantes/export', [ReportsController::class, 'searchEstudiantes']);
    Route::get('/pagos/reporte/export', [ReportsController::class, 'reportsPagos'])->name('admin.pagos.informe');
    Route::post('/pagos/export', [ReportsController::class, 'searchPagos']);
    Route::get('/asistencias/reporte/export', [ReportsController::class, 'reportsAsistencias'])->name('admin.asistencias.informe');
    Route::post('/asistencias/export', [ReportsController::class, 'searchAsistencias']);
    
    Route::get('/materias/reporte/export', MateriaReportes::class)->name('admin.materias.informe');
    //Route::get('/pagos/reporte/export', PagosReportes::class)->name('admin.pagos.informe');
    ///Gestion Inventario
    Route::get('/lista/inventario/ingredientes', [CocinaController::class, 'inventarioIndex'])->name('admin.gestion.inventario');
    Route::get('/inventario/ingrediente/form', [CocinaController::class, 'createForm'])->name('admin.gestion.inventario.form');
    Route::get('/inventario/ingrediente/edit/{id}', [CocinaController::class, 'editForm'])->name('admin.gestion.inventario.edit');
    Route::post('/inventario/store/form', [CocinaController::class, 'guardarInventario'])->name('admin.gestion.inventario.store');
    Route::put('/inventario/update/form/{id}', [CocinaController::class, 'updateInventario'])->name('admin.gestion.inventario.update');
    Route::delete('/inventario/deba/{id}', [CocinaController::class, 'darBajaInvetario'])->name('admin.gestion.inventario.estado');
    Route::get('/inventario/borrar/{id}', [CocinaController::class, 'eliminarInvetario'])->name('admin.gestion.inventario.borrar');
    Route::post('/cantidad/update/{id}', [CocinaController::class, 'updateCantidad'])->name('admin.inventario.update.cantidad');
    Route::get('/historial/inventario', HistorialInventario::class)->name('admin.inventario.historial');
    ///Importacion
    Route::post('/import-admin', [InfoController::class, 'importDatos'])->name('admin.import');
    Route::get('/quitar-role/{id}', [UsersController::class, 'quitarRole'])->name('quita.role');
});

Route::middleware(['auth', 'role:Docente'])->group(function () {
    Route::get('/chef-dashboard', [DocenteController::class, 'index'])->name('docente.home');
    Route::get('/trabajo/nueva/post/{id}', [DocenteCursoController::class, 'createTareaNew'])->name('nueva.tarea.docente');
    Route::get('/trabajo/editar/post/{id}', [DocenteCursoController::class, 'editarTareaEdit'])->name('editra.trabajo.docente');
    Route::post('/trabajo/tarea/new', [DocenteCursoController::class, 'crearTarea'])->name('guardar.tarea.new');
    
    Route::get('/trabajo/file/delete/{id}/file', [DocenteCursoController::class, 'borrarFile'])->name('docente.borrar.file');

    Route::put('/trabajo/tarea/edit/{id}', [DocenteCursoController::class, 'updateTrabajo'])->name('docente.update.trabajo');
    Route::get('/editar/tema/{id}', [DocenteCursoController::class, 'viewTemeEdit'])->name('docente.edit.tema');
    Route::put('/editar/tema/{id}/update', [DocenteCursoController::class, 'updateTema'])->name('docente.update.tema');

    Route::post('/planificacion/curso/{id}', [DocenteController::class, 'planificacion'])->name('guardar.planificacion');
    
    Route::post('/selectReceta',[DocenteCursoController::class, 'selectReceta'])->name('search.recetas');
});
Route::middleware(['auth', 'role:Estudiante'])->group(function () {
    Route::get('/calendar/mostrar/trabajos', [CalendarioController::class, 'mostrarTrabajos'])->name('admin.calendario.trabajos');
    Route::get('/estud-dashboard', [EstudianteController::class, 'index'])->name('estudiante.home');
    Route::get('/cursos/carrera/bamos', [EstudianteController::class, 'cursos'])->name('cursos.carrera');
    Route::get('/estud-submit/{id}/{edit}/editar', SubirTarea::class)->name('estudiante.subir.tarea');
    Route::get('/calificaiones', [EstudianteController::class, 'calificaionesMaterias'])->name('estudiante.calificaciones');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/criterios/tareas/eval', [CriterioController::class, 'index'])->name('admin.tareas.criterios');
    Route::post('/criterios/add/store', [CriterioController::class, 'criteroAdd'])->name('admin.store.criterios');
    Route::get('/criterios/edit/{id}', [CriterioController::class, 'pageCriteroUpdate'])->name('admin.editar.criterios');
    Route::put('/criterios/edit/update/{id}', [CriterioController::class, 'criteroUpdate'])->name('admin.update.criterios');
    Route::delete('/criterios/delete/{id}', [CriterioController::class, 'criterioDelete'])->name('admin.delete.criterios');
    Route::post('/criterios/add/cat/store', [CriterioController::class, 'criteroCatAdd'])->name('admin.store.cat.criterios');
    Route::get('/criterios/edit/cat/{id}', [CriterioController::class, 'pageCriteroCatUpdate'])->name('admin.editar.cat.criterios');
    Route::put('/criterios/edit/cat/update/{id}', [CriterioController::class, 'criteroCatUpdate'])->name('admin.update.cat.criterios');
    Route::delete('/criterios/delete/cat/{id}', [CriterioController::class, 'criterioCatDelete'])->name('admin.delete.cat.criterios');
    Route::get('/select/ponderacion/{id}', [CriterioController::class, 'selectPonderacion'])->name('select.ponderacion');
    //calendario
    Route::get('/calendar/mostrar', [CalendarioController::class, 'mostrar'])->name('admin.calendario.ver');
    Route::get('/calendar/inicio/fin', [CalendarioController::class, 'mostrarInicioFin'])->name('admin.calendario.ver.curso.asignar');
    //cocina Ingredientes
    Route::get('/ingretientes-all', [CocinaController::class, 'allIngredientes'])->name('admin.ingredientes');
    Route::get('/recetas-all/dsgsa', [CocinaController::class, 'allrecetas'])->name('admin.recetas');
    Route::get('/recetas-show/{id}', [CocinaController::class, 'showReceta'])->name('admin.show.receta');
    Route::delete('/recetas-eliminar/{id}', [CocinaController::class, 'deleteReceta'])->name('admin.receta.eliminar');
    Route::post('/select',[CocinaController::class, 'selectIngredientes'])->name('search.ingredientes');
    Route::post('/admin/buscar-ingredientes', [CocinaController::class, 'buscarIngredientes'])->name('admin.buscar-ingredientes');
    Route::get('/agregar-receta/nueva', NewReceta::class)->name('recetas.add');
    
    Route::get('/profile', ProfilePage::class)->name('users.profile');
    Route::post('/new-type/ingrediente', [CocinaController::class, 'guardarIngrediente'])->name('new.ingrediente.db');
    Route::post('/new/recipe/generate', [CocinaController::class, 'generarRecetaOpenAI'])->name('new.receta.generation');
    Route::post('/guardar/recipe/generate/AI', [CocinaController::class, 'guardarRecetaOpenAI'])->name('store.receta.AI');
    Route::get('/show/recipe/{id}', [RecetaController::class, 'showRecipeGenerate'])->name('show.recipe.generate');
    //Cursos
    Route::get('/cursos', [DocenteCursoController::class, 'index'])->name('chef.cursos');
    Route::get('/curso/{id}/materia', [DocenteCursoController::class, 'curso'])->name('cursos.curso');
    //Componetes
    Route::get('/posts-tareas/{id}', ShowTarea::class)->name('show.tarea');
    Route::post('/store/evaluacion/jajaja', [EstudianteController::class, 'evaluacionDocente'])->name('store.evaluacion.docente');
    //notificaciones
    Route::get('/send-whatsapp', [InfoController::class, 'sendWhatsAppMessage']);
    Route::get('/suma', [CocinaController::class, 'suma']);
    Route::get('/generar-receta/add', [RecetaController::class, 'listRecetasGeneradas'])->name('receta.generadas.list');
});

Route::get('terminos-de-uso', [InfoController::class, 'termOfUse'])->name('term.of.use');
Route::get('privacidad-politicas', [InfoController::class, 'privacPolitics'])->name('privacy.politics');

Route::get('/change-password', [AuthController::class, 'pageCambiarContraseña'])->name('form.change.password');
Route::post('/confirm-number', [AuthController::class, 'enviarCodigo'])->name('confirm.code');
Route::get('/reiniciar-contrasenia', [AuthController::class, 'verificarCodigo'])->name('verify.code');
Route::post('/verify-code', [AuthController::class, 'verificarCodigoPassword'])->name('verify.code.pass');
Route::get('/verify-code/pass{user}/', [AuthController::class, 'pagePassword'])->name('verify.code.pass.page');
Route::post('/actualizar-contrasenia', [AuthController::class, 'actualizarPassword'])->name('update.password.code');
