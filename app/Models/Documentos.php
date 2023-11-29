<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;
    protected $table = "documentos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'url', 'fecha', 'estado', 'materia_id', 'user_id', 'tarea_id'];
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
        return $this->belongsTo(Trabajo::class, 'tarea_id');
    }

}
