<?php

namespace App\Exports;

use App\Models\PembayaranPphKlaim;
use Maatwebsite\Excel\Concerns\FromCollection;

class PembayaranPphKlaimExport implements FromCollection
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
        return PembayaranPphKlaim::whereBetween('TGL BAYAR', $this->start, $this->end)->get();
    }
}
