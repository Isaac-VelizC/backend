<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;
    protected $table = "trabajos";
    protected $primaryKey = "id";
    protected $fillable = ['tipo_id',
        'curso_id',
        'user_id',
        'tema_id',
        'titulo',
        'descripcion',
        'inico',
        'fin',
        'con_nota',
        'nota',
        'visible',
        'estado'
    ];
    public function curso()
    {
        return $this->belongsTo(CursoHabilitado::class, 'curso_id');
    }
    public function Tipo()
    {
        return $this->belongsTo(TipoTrabajo::class, 'tipo_id');
    }
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }
    public function tareasEstudiantes()
    {
        return $this->hasMany(TrabajoEstudiante::class, 'tarea_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
