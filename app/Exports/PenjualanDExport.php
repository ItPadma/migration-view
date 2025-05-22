<?php

namespace App\Exports;

use App\Models\PenjualanD;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjualanDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PenjualanD::all();
    }
}
