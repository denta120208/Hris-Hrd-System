<?php

namespace App\Models\Trainning;

use Illuminate\Database\Eloquent\Model;

class TrainningRequest extends Model{
    public $timestamps = false;
    protected $table = 'emp_trainning_request';

    protected $fillable = [
        'emp_number','requested_at','trainning_id','trainning_intitusion','trainning_silabus','trainning_purpose'
        ,'trainning_costs','trainning_start_date','trainning_end_date','trainning_share_date','approved_sup_by'
        ,'approved_sup_at','approved_hr_by','approved_hr_at','approved_dir_by','approved_dir_at','training_status'
    ];

    public function training_name(){
        return $this->belongsTo('App\Models\Trainning\Trainning', 'trainning_id', 'id');
    }
    public function institutions_name(){
        return $this->belongsTo('App\Models\Trainning\TrainningVendor', 'trainning_intitusion', 'id');
    }
}
