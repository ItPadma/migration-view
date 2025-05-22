<?php

namespace App\Exports;

use App\Models\MbeliH;
use Maatwebsite\Excel\Concerns\FromCollection;

class MbeliHExport implements FromCollection
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
        return MbeliH::whereBetwaen('TglReceiving', $this->start, $this->end)->get();
    }
}
