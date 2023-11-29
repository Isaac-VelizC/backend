<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "temas";
    protected $primaryKey = "id";
    protected $fillable = ['tema', 'curso_id', 'estado'];
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'tema_id');
    }
}
