<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseKas extends Model
{
    protected $connection = 'sqlsrv_252';
    protected $table = 'Expense_Kas';
}
