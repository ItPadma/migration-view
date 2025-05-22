<?php

namespace App\Exports;

use App\Models\SaldoPiutang;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaldoPiutangExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SaldoPiutang::all();
    }
}
