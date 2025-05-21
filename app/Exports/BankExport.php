<?php

namespace App\Exports;

use App\Models\ExpenseBank;
use Maatwebsite\Excel\Concerns\FromCollection;

class BankExport implements FromCollection
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
        return ExpenseBank::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
