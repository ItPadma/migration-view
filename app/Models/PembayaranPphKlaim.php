<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPphKlaim extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Data_Pembayaran_PPH_Klaim';
}
