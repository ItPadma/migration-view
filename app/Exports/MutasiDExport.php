<?php

namespace App\Exports;

use App\Models\MutasiD;
use Maatwebsite\Excel\Concerns\FromCollection;

class MutasiDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MutasiD::all();
    }
}
