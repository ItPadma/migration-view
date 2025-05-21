<?php

namespace App\Exports;

use App\Models\ExpensePelunasanPiutang;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelunasanPiutangExport implements FromCollection
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
        return ExpensePelunasanPiutang::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
