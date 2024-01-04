<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionDocente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "evaluacion_docente";
    protected $primaryKey = "id";
    protected $fillable = ['codigo'];
    
    public function preguntas()
    {
        return $this->hasMany(PreguntaEvaluacionDocente::class, 'id_evaluacion', 'id');
    }
}

class EvalRespuestas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "eval_respuestas";
    protected $primaryKey = "id";
    protected $fillable = ['pregunta_id', 'habilitado_id', 'texto', 'fecha'];
    
    public function pregunta()
    {
        return $this->belongsTo(PreguntaEvaluacionDocente::class, 'pregunta_id', 'id');
    }

    public function habilitadoEvaluacion()
    {
        return $this->belongsTo(EvaluacionHabilitada::class, 'habilitado_id', 'id');
    }
}
