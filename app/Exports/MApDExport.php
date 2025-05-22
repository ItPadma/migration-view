<?php

namespace App\Exports;

use App\Models\MApD;
use Maatwebsite\Excel\Concerns\FromCollection;

class MApDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MApD::all();
    }
}
