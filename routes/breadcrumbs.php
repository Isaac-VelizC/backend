<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
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