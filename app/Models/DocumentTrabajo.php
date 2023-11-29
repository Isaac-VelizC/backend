<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTrabajo extends Model
{
    use HasFactory;
    protected $table = "document_trabajos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'url', 'fecha', 'estado', 'trabajo_estudiante_id', 'user_id', 'trabajo_id'];

    public function curso()
    {
        return $this->belongsTo(CursoDocente::class, 'materia_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tarea()
    {
        return $this->belongsTo(Trabajo::class, 'trabajo_id');
    }
}
