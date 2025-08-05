<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model{
    public $timestamps = false;
    protected $table = 'emp_leave_request';

    protected $fillable = ['id',
        'leave_type_id',
        'date_applied',
        'emp_number',
        'leave_status',
        'person_in_charge',
        'comments',
        'length_days',
        'from_date',
        'end_date',
        'created_at',
        'created_by',
        'approved_at',
        'approved_by',
        'pnum',
        'ptype'
    ];
    public function empName(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function emp_approve(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function leave_type(){
        return $this->belongsTo('App\Models\Leave\LeaveType', 'leave_type_id', 'id');
    }
    public function leave_stat(){
        return $this->belongsTo('App\Models\Leave\LeaveStatus', 'leave_status', 'id');
    }
    public function empInCharge(){
        return $this->belongsTo('App\Models\Master\Employee', 'person_in_charge', 'emp_number');
    }
}
