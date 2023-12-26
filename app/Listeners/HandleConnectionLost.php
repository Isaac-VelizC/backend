<?php

namespace App\Listeners;

use App\Events\ConnectionLost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleConnectionLost
{
    public function __construct()
    {
        //
    }

    public function handle(ConnectionLost $event): void
    {
        Log::error('¡Conexión a la base de datos perdida!');
    }
}
