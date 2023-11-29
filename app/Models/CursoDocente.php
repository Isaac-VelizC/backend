<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoDocente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "curso_docentes";
    protected $primaryKey = "id";
    protected $fillable = ['docente_id',
        'curso_id',
        'responsable_id',
        'horario_id',
        'aula_id',
        'descripcion',
        'imagen',
        'fecha_ini',
        'fecha_fin',
        'whatsapp',
        'estado'
    ];
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'curso_id', 'curso_id');
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }
    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'materia_id');
    }
}
