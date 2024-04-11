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
    protected $fillable = ['nombre', 'cupo', 'color', 'estado', 'habilit','descripcion', 'fecha'];

    public function participantes()
    {
        return $this->hasMany(Participante::class, 'curso_id');
    }
}
