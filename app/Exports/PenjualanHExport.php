<?php

namespace App\Exports;

use App\Models\PenjualanH;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjualanHExport implements FromCollection
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
        return PenjualanH::whereBetween('TglDO', [$this->start, $this->end])->get();
    }
}
