<?php

namespace App\Models\PerjanalanDinas;

use Illuminate\Database\Eloquent\Model;

class PDRequest extends Model
{
    public $timestamps = false;
    protected $table = 'emp_pd_request';

    protected $fillable = ['id',
        'emp_number',
        'pd_start_date',
        'pd_end_date',
        'pd_length_day',
        'pd_status',
        'pd_reason',
        'pd_project_des',
        'created_at',
        'created_by',
        'approved_at',
        'approved_by',
        'updated_at',
        'updated_by',
    ];
    public function pdStatus(){
        return $this->belongsTo('App\Models\PerjanalanDinas\PDStatus', 'pd_status', 'id');
    }
    public function emp_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
    public function emp_id_name(){
        return $this->belongsTo('App\Models\Master\Employee', 'approved_by', 'employee_id');
    }
}
