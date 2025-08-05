<?php

namespace App\Models\Mutations;

use Illuminate\Database\Eloquent\Model;

class MutationRequest extends Model{
    public $timestamps = false;
    protected $table = 'emp_mutation_request';

    protected $fillable = ['id',
        'sub_emp_number',
        'sup_emp_number',
        'mt_type', // Status Mutasi (Permanen atau Diperbantukan)
        'mt_status', // Status Request Mutasi 1 - Requested, 2 - Approved, 3 - HRD Approved
        'mt_reason',
        'mt_from_loc',
        'mt_to_loc',
        'mt_from_dept',
        'mt_to_dept',
        'mt_title_to',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'approved_at',
        'approved_by',
        'hrd_approved_at',
        'hrd_approved_by'
    ];

    public function emp_sub(){
        return $this->belongsTo('App\Models\Master\Employee', 'sub_emp_number', 'emp_number');
    }
    public function emp_sup(){
        return $this->belongsTo('App\Models\Master\Employee', 'sup_emp_number', 'emp_number');
    }
    public function mutation_type(){
        return $this->belongsTo('App\Models\Mutations\MutationType', 'mt_type', 'id');
    }
    public function mutation_status(){
        return $this->belongsTo('App\Models\Mutations\MutationStatus', 'mt_status', 'id');
    }
    public function project_from(){
        return $this->belongsTo('App\Models\Master\Location', 'mt_from_loc', 'id');
    }
    public function project_to(){
        return $this->belongsTo('App\Models\Master\Location', 'mt_to_loc', 'id');
    }
    public function dept_from(){
        return $this->belongsTo('App\Models\Employee\EmpDept', 'mt_from_dept', 'id');
    }
    public function dept_to(){
        return $this->belongsTo('App\Models\Employee\EmpDept', 'mt_to_dept', 'id');
    }
    public function title_to(){
        return $this->belongsTo('App\Models\Master\JobTitle', 'mt_title_to', 'id');
    }
}
