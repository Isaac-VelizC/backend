<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pagos";
    protected $primaryKey = "id";
    protected $fillable = ['responsable_id', 'est_id', 'metodo_id', 'fecha', 'monto', 'estado', 'comentario'];

}
