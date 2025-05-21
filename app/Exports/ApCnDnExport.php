<?php

namespace App\Exports;

use App\Models\ExpenseApCnDn;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApCnDnExport implements FromCollection
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
        return ExpenseApCnDn::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
