<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAppraisalType extends Model{
    public $timestamps = false;
    protected $table = 'emp_appraisal_type';

    protected $fillable = ['emp_number','appraisal_type_id','is_delete'];

    public function code(){
        return $this->belongsTo('App\Models\Master\AppraisalType', 'appraisal_type_id', 'id');
    }
}
