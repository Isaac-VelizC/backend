<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = "tipo_trabajos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre'];
}
