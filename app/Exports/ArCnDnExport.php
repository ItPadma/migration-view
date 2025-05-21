<?php

namespace App\Exports;

use App\Models\ExpenseArCnDn;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArCnDnExport implements FromCollection
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
        return ExpenseArCnDn::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
