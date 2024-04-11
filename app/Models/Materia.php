<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "materias";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'semestre_id', 'color', 'estado', 'dependencia','descripcion'];

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }
}
