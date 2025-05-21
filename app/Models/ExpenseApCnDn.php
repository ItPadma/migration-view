<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseApCnDn extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Expense_AP_CNDN';
}
