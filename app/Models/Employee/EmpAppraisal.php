<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAppraisal extends Model{
    public $timestamps = false;
    protected $table = 'emp_appraisal';

    protected $fillable = ['emp_number','appraisal_id','appraisal_value_id','appraisal_value','emp_evaluator'
        ,'evaluator_as','hrd_value','period','hrd_date','appraisal_status','created_at','updated_at', 'box_9_appraisal'
    ];

}
