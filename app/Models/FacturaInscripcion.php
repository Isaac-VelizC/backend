<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaInscripcion extends Model
{
    use HasFactory;
    protected $table = "factura_inscripcions";
    protected $primaryKey = "id";
    protected $fillable = ['inscrito_id', 'fecha', 'codigo', 'estado'];

}
