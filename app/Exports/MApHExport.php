<?php

namespace App\Exports;

use App\Models\MApH;
use Maatwebsite\Excel\Concerns\FromCollection;

class MApHExport implements FromCollection
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
        return MApH::whereBetween('TglInvoice', [$this->start, $this->end])->get();
    }
}
