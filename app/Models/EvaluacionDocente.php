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
    protected $fillable = ['pregunta_id', 'codigo'];
    
    public function pregunta()
    {
        return $this->belongsTo(EvalPreguntas::class, 'pregunta_id', 'id');
    }
}

class EvalPreguntas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "eval_preguntas";
    protected $primaryKey = "id";
    protected $fillable = ['numero', 'texto'];

    public function respuestas()
    {
        return $this->hasMany(EvalRespuestas::class, 'pregunta_id', 'id');
    }
    
}

class HabilitadoEvaluacion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "habilitado_evaluacion";
    protected $primaryKey = "id";
    protected $fillable = ['materia_id', 'eval_docente_id', 'fecha', 'estado'];
    
    public function materia()
    {
        return $this->belongsTo(CursoHabilitado::class, 'materia_id', 'id');
    }

    public function evaluacionDocente()
    {
        return $this->belongsTo(EvaluacionDocente::class, 'eval_docente_id', 'id');
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
        return $this->belongsTo(EvalPreguntas::class, 'pregunta_id', 'id');
    }

    public function habilitadoEvaluacion()
    {
        return $this->belongsTo(HabilitadoEvaluacion::class, 'habilitado_id', 'id');
    }
}
