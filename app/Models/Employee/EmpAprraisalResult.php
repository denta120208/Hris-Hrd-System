<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAprraisalResult extends Model
{
    public $timestamps = false;
    protected $table = 'emp_appraisal_result';

    protected $fillable = ['id','emp_number','appraisal_result_val','train_suggest','box9','years','created_at','created_by'];
}
