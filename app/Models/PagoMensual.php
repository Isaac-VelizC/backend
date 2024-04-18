<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoMensual extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pago_mensuals";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id',  'metodo_id', 'pago_id', 'mes', 'anio', 'fecha', 'pagado', 'codigo', 'monto'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
    
    public function pago()
    {
        return $this->belongsTo(Pagos::class, 'id', 'pago_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_id');
    }
}
