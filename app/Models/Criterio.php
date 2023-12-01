<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;
    protected $table = "criterios";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'porcentaje', 'total', 'curso_id'];

}
