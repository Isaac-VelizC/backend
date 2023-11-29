<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "cursos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'precio', 'periodo_id', 'color', 'estado', 'descripcion'];

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
    public function cursoDocentes()
    {
        return $this->hasMany(CursoDocente::class, 'curso_id');
    }
}
