<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpContract extends Model{
    public $timestamps = false;
    protected $table = 'emp_contract';

    protected $fillable = ['emp_number','econ_extend_id','econ_extend_start_date',
    'econ_extend_end_date','template_id','econ_status','emp_number_old','econ_number','econ_doc','is_delete'];
}
