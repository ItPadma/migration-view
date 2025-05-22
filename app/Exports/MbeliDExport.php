<?php

namespace App\Exports;

use App\Models\MbeliD;
use Maatwebsite\Excel\Concerns\FromCollection;

class MbeliDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MbeliD::all();
    }
}
