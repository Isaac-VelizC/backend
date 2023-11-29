<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $table = "curso_evaluacion";
    protected $primaryKey = "id";
    protected $fillable = ['curso_id', 'evaluacion_tipo_id', 'cat_crit_id', 'user_id', 'titulo', 'descripcion', 'doc_id', 'cantidad', 'inicio', 'fin', 'con_nota', 'nota', 'visible', 'estado'];

}
