<?php

namespace App\Exports;

use App\Models\ExpensePelunasanHutangD;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelunasanHutangDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ExpensePelunasanHutangD::all();
    }
}
