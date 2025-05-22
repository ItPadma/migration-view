<?php

namespace App\Exports;

use App\Models\MutasiH;
use Maatwebsite\Excel\Concerns\FromCollection;

class MutasiHExport implements FromCollection
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
        return MutasiH::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
