<?php

namespace App\Exports;

use App\Models\PembayaranKlaim;
use Maatwebsite\Excel\Concerns\FromCollection;

class PembayaranKlaimExport implements FromCollection
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
        return PembayaranKlaim::whereBetween('TGL BAYAR', [$this->start, $this->end])->get();
    }
}
