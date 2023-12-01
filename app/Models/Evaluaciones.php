<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluaciones extends Model
{
    use HasFactory;
    protected $table = "evaluaciones";
    protected $primaryKey = "id";
    protected $fillable = ['curso_id', 'tipo_id', 'user_id', 'titulo', 'descripcion', 'inicio', 'fin', 'con_nota', 'nota', 'visible', 'estado'];

}
