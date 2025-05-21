<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoAwalKlaim extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Data_Saldo_Awal_Klaim';
}
