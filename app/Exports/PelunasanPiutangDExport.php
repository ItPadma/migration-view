<?php

namespace App\Exports;

use App\Models\ExpensePelunasanPiutangD;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelunasanPiutangDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ExpensePelunasanPiutangD::all();
    }
}
