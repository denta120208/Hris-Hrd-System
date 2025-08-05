<?php

namespace App\Models\Trainning;

use Illuminate\Database\Eloquent\Model;

class TrainningEmp extends Model{
    public $timestamps = false;
    protected $table = 'emp_trainning';

    protected $fillable = [
        'emp_number','license_id','license_no','license_issued_date','license_expiry_date'
    ];

    public function trainning(){
        return $this->belongsTo('App\Models\Master\Trainning', 'license_id', 'id');
    }
}
