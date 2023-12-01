<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $table = "preguntas";
    protected $primaryKey = "id";
    protected $fillable = ['pregunta', 'curso_id', 'con_nota', 'nota', 'inicio', 'estado', 'tema_id', 'limite'];
    public function curso()
    {
        return $this->belongsTo(CursoHabilitado::class, 'curso_id');
    }
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }
    public function preguntasEstudiantes()
    {
        return $this->hasMany(PreguntaEstudiante::class, 'pregunta_id');
    }
}
