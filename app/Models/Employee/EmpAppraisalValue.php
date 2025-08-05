<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAppraisalValue extends Model {
    public $timestamps = false;
    protected $table = 'emp_appraisal_value';

    protected $fillable = ['emp_number','period','emp_value','emp_later','emp_box_9', 'emp_val_status','sup_value','sup_later','sup_box_9', 'sup_val_status'
        ,'dir_value','dir_later','dir_box_9', 'dir_val_status','hrd_value','hrd_later','hrd_box_9', 'hrd_val_status'];
}
