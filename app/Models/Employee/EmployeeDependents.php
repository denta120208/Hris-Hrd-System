<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeDependents extends Model
{
    protected $table = 'employee_dependents';
    protected $fillable = [
        'ed_emp_id',
        'ed_name',
        'ed_relationship',
        'ed_date_of_birth'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'ed_emp_id');
    }
} 