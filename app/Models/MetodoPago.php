<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "metodo_pagos";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'monto', 'estado'];
    
    public function mensualPago()
    {
        return $this->hasMany(PagoMensual::class, 'metodo_id');
    }

}

