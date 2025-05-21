<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseBank extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Expense_Bank';
}
