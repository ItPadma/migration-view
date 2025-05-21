<?php

namespace App\Exports;

use App\Models\ExpensePelunasanHutang;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelunasanHutangExport implements FromCollection
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
        return ExpensePelunasanHutang::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
