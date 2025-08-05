<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpTerminate extends Model{
    public $timestamps = false;
    protected $table = 'emp_termination';

    protected $fillable = ['emp_number', 'reason_id', 'termination_date', 'note', 'status'];
}
