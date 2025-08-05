<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpDept extends Model{
    public $timestamps = false;
    protected $table = 'emp_dept';

    protected $fillable = ['id','name','created_at','created_by'];
}
