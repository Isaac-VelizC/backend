<?php

namespace App\Livewire\Admin\Informe;

use Livewire\Component;

class PagosReportes extends Component
{
    public function render()
    {
        return view('livewire.admin.informe.pagos-reportes')->extends('layouts.app')->section('content');
    }
}
