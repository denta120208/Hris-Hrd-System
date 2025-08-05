<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveEntitlement extends Model{
    public $timestamps = false;
    protected $table = 'leave_entitlement';

    protected $fillable = [
        'emp_number','no_of_days','days_used','leave_type_id','from_date','to_date','credited_date'
        ,'note','entitlement_type','deleted','created_by_id','created_by_name','emp_number_old'
    ];

    public function entitlement_title(){
        return $this->belongsTo('App\Models\Leave\LeaveType', 'leave_type_id', 'id');
    }
}