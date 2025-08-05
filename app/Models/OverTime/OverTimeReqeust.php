<?php

namespace App\Models\OverTime;

use Illuminate\Database\Eloquent\Model;

class OverTimeReqeust extends Model{
    public $timestamps = false;
    protected $table = 'emp_ot_reqeuest';

    protected $fillable = ['id',
        'attendance_id',
        'emp_number',
        'ot_date',
        'ot_start_time',
        'ot_end_time',
        'ot_hours',
        'ot_total_hours',
        'ot_meal_num',
        'ot_status',
        'ot_reason',
        'ot_comment',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'approved_at',
        'approved_by'
    ];
    public function overtime_status(){
            return $this->belongsTo('App\Models\OverTime\OverTimeStatus', 'ot_status', 'id');
        }
    public function emp_name(){
            return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function emp_id_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'approved_by', 'employee_id');
    }
}