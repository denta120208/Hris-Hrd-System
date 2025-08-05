<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class StatusReqAttendance extends Model{
    public $timestamps = false;
    protected $table = 'attendance_status_req';

    protected $fillable = ['name'];

}
