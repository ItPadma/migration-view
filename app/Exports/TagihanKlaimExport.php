<?php

namespace App\Exports;

use App\Models\TagihanKlaim;
use Maatwebsite\Excel\Concerns\FromCollection;

class TagihanKlaimExport implements FromCollection
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
        return TagihanKlaim::whereBetween('TGL PIUTANG KLAIM', [$this->start, $this->end])->get();
    }
}
