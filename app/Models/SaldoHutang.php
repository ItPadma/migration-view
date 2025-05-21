<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoHutang extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'SaldoHutang';
}
