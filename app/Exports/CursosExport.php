<?php

namespace App\Exports;

use App\Models\Curso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CursosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Curso::with('semestre')
        ->select('nombre', 'color', 'semestre_id', 'estado')
        ->get();
    }
    public function headings(): array
    {
        return ['Nombre', 'Color', 'Semestre', 'Estado'];
    }
    public function map($row): array
    {
        return [
            $row->nombre,
            $row->color,
            optional($row->semestre)->nombre,
            $row->estado ? 'Activo' : 'Inactivo',
        ];
    }
}
