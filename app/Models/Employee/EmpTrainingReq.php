<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpTrainingReq extends Model{
    public $timestamps = false;
    protected $table = 'emp_trainning_request';

    protected $fillable = ['emp_number','requested_at','trainning_id','trainning_intitusion','trainning_silabus',
    'trainning_purpose','trainning_costs','trainning_start_date','trainning_end_date','trainning_share_date',
    'approved_sup_by','approved_sup_at','approved_hr_by','approved_hr_at','approved_dir_by','pproved_dir_at',
    'training_status','pnum','ptype'
    ];

    public function emp_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function train_name(){
        return $this->belongsTo('App\Models\Master\Trainning', 'trainning_id', 'id');
    }
    public function train_vendor(){
        return $this->belongsTo('App\Models\Trainning\TrainningVendor', 'trainning_intitusion', 'id');
    }
}
