<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpReportTo extends Model{
    public $timestamps = false;
    protected $table = 'emp_reportto';

    protected $fillable = ['erep_sup_emp_number','erep_sub_emp_number','erep_reporting_mode'];
}
