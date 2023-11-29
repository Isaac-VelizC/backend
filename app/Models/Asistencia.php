<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = "asistencias";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id', 'curso_id', 'asistencia', 'fecha', 'estado'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id', 'id');
    }
    public function cursoDocente()
    {
        return $this->belongsTo(CursoDocente::class, 'curso_id', 'curso_id');
    }
    public function student()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function event()
    {
        return $this->belongsTo(Evento::class);
    }

    public function attendanceType()
    {
        return $this->belongsTo(TipoAsistensia::class);
    }

    /**
     * get absences count per student
     * this is useful for monitoring the absences.
     */
    public function obtener_recuento_ausencias_estudiante(Periodo $period)
    {
        // return attendance records for period
        $coursesIds = $period->courses->pluck('id');
        $eventsIds = Evento::whereIn('curso_id', $coursesIds)->pluck('id');

        return self::with('evento.curso')->with('estudiante')->whereIn('evento_id', $eventsIds)->whereIn('attendance_type_id', [3, 4])->get()->groupBy('estudiante_id');
    }

    public function getStudentNameAttribute(): string
    {
        return $this->student->name ?? '';
    }
}
