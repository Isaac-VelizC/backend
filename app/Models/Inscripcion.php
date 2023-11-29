<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = "inscripcions";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id', 'responsable_id', 'materia_id', 'inscrito', 'estado'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
    public function cursoDocente()
    {
        return $this->belongsTo(CursoDocente::class, 'materia_id');
    }
}
