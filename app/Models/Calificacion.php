<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;
    protected $table = "calificacions";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id', 'curso_id', 'num_trabajos', 'num_evaluaciones', 'calificacion'];

}
