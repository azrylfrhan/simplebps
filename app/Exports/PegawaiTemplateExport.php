<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class PegawaiTemplateExport implements WithHeadings
{
    public function headings(): array
    {

        return [
            'Nama Lengkap',
            'Jabatan',
            'Tim'
        ];
    }
}
