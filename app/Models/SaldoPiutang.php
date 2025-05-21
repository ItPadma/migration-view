<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoPiutang extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'SaldoPiutang';
}
