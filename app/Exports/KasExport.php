<?php

namespace App\Exports;

use App\Models\ExpenseKas;
use Maatwebsite\Excel\Concerns\FromCollection;

class KasExport implements FromCollection
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
        return ExpenseKas::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
