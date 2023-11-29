<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pagos";
    protected $primaryKey = "id";
    protected $fillable = ['responsable_id', 'metodo_id', 'factura_id', 'fecha', 'valor', 'estado', 'comentario'];

}
