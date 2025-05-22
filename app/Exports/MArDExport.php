<?php

namespace App\Exports;

use App\Models\MArD;
use Maatwebsite\Excel\Concerns\FromCollection;

class MArDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MArD::all();
    }
}
