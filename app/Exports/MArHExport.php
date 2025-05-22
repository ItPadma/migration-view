<?php

namespace App\Exports;

use App\Models\MArH;
use Maatwebsite\Excel\Concerns\FromCollection;

class MArHExport implements FromCollection
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
        return MArH::whereBetween('TglInvoice', [$this->start, $this->end])->get();
    }
}
