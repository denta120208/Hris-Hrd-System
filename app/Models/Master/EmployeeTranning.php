<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class EmployeeTranning extends Model{
    public $timestamps = false;
    protected $table = 'emp_trainning';

    protected $fillable = ['emp_number','train_name','license_no','license_issued_date','license_expiry_date','pnum','ptype','is_delete'];

    public function trainning(){
        return $this->belongsTo('App\Models\Master\Trainning', 'license_id', 'id');
    }
}
