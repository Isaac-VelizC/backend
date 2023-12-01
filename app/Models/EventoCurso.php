<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoCurso extends Model
{
    use HasFactory;
    protected $table = "evento_cursos";
    protected $primaryKey = "id";
    protected $fillable = ['tarea_id', 'evaluacion_id', 'start', 'end', 'title', 'descripcion', 'estado'];

}
