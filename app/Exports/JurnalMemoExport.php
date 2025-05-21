<?php

namespace App\Exports;

use App\Models\ExpenseJurnalMemo;
use Maatwebsite\Excel\Concerns\FromCollection;

class JurnalMemoExport implements FromCollection
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
        return ExpenseJurnalMemo::whereBetween('Tgl', $this->start, $this->end)->get();
    }
}
