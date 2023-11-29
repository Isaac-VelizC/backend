<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "periodos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'costo', 'descripcion'];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'periodo_id');
    }
}
