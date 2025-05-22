<?php

namespace App\Exports;

use App\Models\KoreksiH;
use Maatwebsite\Excel\Concerns\FromCollection;

class KoreksiHExport implements FromCollection
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
        return KoreksiH::whereBetween('Tgl', [$this->start, $this->end])->get();
    }
}
