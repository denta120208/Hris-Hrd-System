<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpEducation extends Model{
    public $timestamps = false;
    protected $table = 'emp_education';

    protected $fillable = ['emp_number','education_id','institute','major','year','score','start_date','end_date','emp_number_old','is_delete'];

    public function education(){
        return $this->belongsTo('App\Models\Master\Education', 'education_id', 'id');
    }
}
