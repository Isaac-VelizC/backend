<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaEstudiante extends Model
{
    use HasFactory;
    protected $table = "preguntas_estudiantes";
    protected $primaryKey = "id";
    protected $fillable = ['pregunta_id','estudiante_id','respuesta','nota','estado'];
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
}
