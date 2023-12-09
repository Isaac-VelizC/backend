<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCurso extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = "pago_cursos";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id', 'curso_id', 'pago_id'];
}
