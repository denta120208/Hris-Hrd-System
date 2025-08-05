<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class AttRecord extends Model{
    public $timestamps = false;
    protected $table = 'attendance_record';

    protected $fillable = ['employee_id','punch_in_utc_time','punch_in_note','punch_in_time_offset',
        'punch_in_user_time','punch_out_utc_time','punch_out_note','punch_out_time_offset','punch_out_user_time',
        'state'];
    public function emp_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'employee_id', 'employee_id');
    }
}
