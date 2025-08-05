<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class RequestAttendance extends Model{
    public $timestamps = false;
    protected $table = 'emp_attendance_request';

    protected $fillable = ['attendance_id','emp_number','start_date','end_date','comIjin','reason',
        'request_status','approve_sup','approve_sup_date','approve_hr','approve_hr_date'];
    public function emp_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function status_name(){
        return $this->belongsTo('App\Models\Attendance\StatusReqAttendance', 'request_status', 'id');
    }
}
