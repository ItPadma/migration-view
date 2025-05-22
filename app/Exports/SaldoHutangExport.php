<?php

namespace App\Exports;

use App\Models\SaldoHutang;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaldoHutangExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SaldoHutang::all();
    }
}
