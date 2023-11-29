<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "facturas";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'client_name', 'client_idnumber', 'client_address', 'client_email', 'client_phone', 'receipt_number', 'fecha'];

}
