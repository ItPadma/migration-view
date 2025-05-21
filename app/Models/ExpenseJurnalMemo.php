<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseJurnalMemo extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Expense_Jurnal_Memo';
}
