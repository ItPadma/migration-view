<?php

namespace App\Exports;

use App\Models\SaldoAwalKlaim;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaldoAwalKlaimExport implements FromCollection
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SaldoAwalKlaim::all();
    }
}
