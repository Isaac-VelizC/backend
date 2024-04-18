<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Receta;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('admin.home'));
});
// Todos los Usuarios
Breadcrumbs::for('Usuarios', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Listado de Usuarios', route('admin.users'));
});
Breadcrumbs::for('gestion.permisos', function (BreadcrumbTrail $trail) {
    $trail->parent('Usuarios');
    $trail->push('Gestionar Permisos y Roles', route('admin.gestion.permisos'));
});
// Estudiantes
Breadcrumbs::for('Estudiantes', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Listado de Estudiantes', route('admin.estudinte'));
});
Breadcrumbs::for('Estudiantes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('Estudiantes');
    $trail->push('Inscripción de Estudiantes', route('admin.inscripcion'));
});
Breadcrumbs::for('Estudiantes.edit', function (BreadcrumbTrail $trail, $est) {
    $trail->parent('Estudiantes');
    $trail->push($est->nombre .' ' .$est->ap_paterno .' '.$est->ap_materno, route('admin.E.show', $est->id));
});

// Docentes
Breadcrumbs::for('Docentes', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Listado de Docentes', route('admin.docentes'));
});
Breadcrumbs::for('Docentes.edit', function (BreadcrumbTrail $trail, $id, $doc) {
    $trail->parent('Docentes');
    $trail->push($doc->nombre .' ' .$doc->ap_paterno .' '.$doc->ap_materno, route('admin.D.show', $id));
});
// Trabajadores
Breadcrumbs::for('Trabajadores', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Listado de Trabajadores', route('admin.personal'));
});
Breadcrumbs::for('Trabajadores.edit', function (BreadcrumbTrail $trail, $id, $doc) {
    $trail->parent('Trabajadores');
    $trail->push($doc->nombre .' ' .$doc->ap_paterno .' '.$doc->ap_materno, route('admin.P.show', $id));
});
// Materias
Breadcrumbs::for('Materias', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Litado de Materias', route('admin.cursos'));
});
Breadcrumbs::for('Materias.Habilitados', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Materias Habilitados', route('admin.cursos.activos'));
});
Breadcrumbs::for('criterios.gestion', function (BreadcrumbTrail $trail,) {
    $trail->parent('Materias.Habilitados');
    $trail->push('Gestionar Criterios', route('admin.tareas.criterios'));
});
Breadcrumbs::for('Materias.show', function (BreadcrumbTrail $trail, $curso) {
    $trail->parent('Materias.Habilitados');
    $trail->push($curso->curso->nombre, route('admin.cursos.show', $curso->id));
});
Breadcrumbs::for('Materias.edit', function (BreadcrumbTrail $trail, $curso) {
    $trail->parent('Materias.Habilitados');
    $trail->push('Editar '.$curso->nombre, route('admin.asigando.edit', $curso->id));
});
Breadcrumbs::for('Materias.create', function (BreadcrumbTrail $trail, $curso) {
    $trail->parent('Materias');
    $trail->push('Habilitar '.$curso->nombre, route('admin.asignar.curso', $curso->id));
});
Breadcrumbs::for('Materias.programar', function (BreadcrumbTrail $trail) {
    $trail->parent('Materias.Habilitados');
    $trail->push('Programar estudiantes', route('admin.cursos.activos'));
});
// Gestionar
Breadcrumbs::for('Gestionar', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Gestionar Campos', route('admin.administracion'));
});
// Recetas
Breadcrumbs::for('recetas.all', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Recetas', route('admin.recetas'));
});
Breadcrumbs::for('recetas.lista', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Recetas', route('admin.ingredientes'));
});
Breadcrumbs::for('recetas.show', function (BreadcrumbTrail $trail, Receta $item) {
    $trail->parent('recetas.lista');
    $trail->push($item->titulo, route('admin.show.receta', $item->id));
});
//informes
Breadcrumbs::for('reportes.meterias', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Reportes Materias', route('admin.materias.informe'));
});
Breadcrumbs::for('reportes.estudiantes', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Reportes de Estudiantes', route('admin.estudiantes.informe'));
});
//evaluacion docente
Breadcrumbs::for('listado.evaluacion', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Evaluacion Docente', route('materia.evaluacion.docente'));
});
Breadcrumbs::for('gestion.evaluacion', function (BreadcrumbTrail $trail) {
    $trail->parent('listado.evaluacion');
    $trail->push('Gestionar Preguntas', route('evaluacion.docente'));
});
Breadcrumbs::for('historial.evaluacion', function (BreadcrumbTrail $trail) {
    $trail->parent('listado.evaluacion');
    $trail->push('Historial Evaluacion Docente', route('historial.evaluacion.docente'));
});
// Home Docente
Breadcrumbs::for('homeDocente', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route(auth()->user()->hasRole('Estudiante') ? 'estudiante.home' : 'docente.home'));
});
//Materias Docente Estudiante
Breadcrumbs::for('materias.inicio', function (BreadcrumbTrail $trail) {
    $trail->parent('homeDocente');
    $trail->push('Materias', route(auth()->user()->hasRole('Estudiante') ? 'cursos.carrera' : 'chef.cursos'));
});
Breadcrumbs::for('Materia.show', function (BreadcrumbTrail $trail, $curso) {
    $trail->parent('materias.inicio');
    $trail->push($curso->curso->nombre, route('cursos.curso', $curso->id));
});
Breadcrumbs::for('trabajo.show', function (BreadcrumbTrail $trail, $curso, $tarea) {
    $trail->parent('Materia.show', $curso);
    $trail->push($tarea->titulo, route('show.tarea', $tarea->id));
});
Breadcrumbs::for('materias.tema', function (BreadcrumbTrail $trail, $tema) {
    $trail->parent('materias.inicio');
    $trail->push($tema->tema, route('docente.edit.tema', $tema->id));
});
// Pagos
Breadcrumbs::for('Pagos.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Listado de Pagos', route('admin.lista.pagos'));
});
Breadcrumbs::for('Pagos.create', function (BreadcrumbTrail $trail) {
    $trail->parent('Pagos.list');
    $trail->push('Registrar nuevo Pago', route('admin.create.pago'));
});
// Inventario
Breadcrumbs::for('Inventario.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Inventario de Ingredientes', route('admin.gestion.inventario'));
});
Breadcrumbs::for('Inventario.create', function (BreadcrumbTrail $trail) {
    $trail->parent('Inventario.list');
    $trail->push('Registrar', route('admin.gestion.inventario.form'));
});
Breadcrumbs::for('Inventario.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('Inventario.list');
    $trail->push('Editar');
});
Breadcrumbs::for('Inventario.historial', function (BreadcrumbTrail $trail) {
    $trail->parent('Inventario.list');
    $trail->push('Historial', route('admin.inventario.historial'));
});