<?php

namespace App\Exports;

use App\Models\KoreksiD;
use Maatwebsite\Excel\Concerns\FromCollection;

class KoreksiDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KoreksiD::all();
    }
}
