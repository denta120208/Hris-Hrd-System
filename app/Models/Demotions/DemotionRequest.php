<?php

namespace App\Models\Demotions;

use Illuminate\Database\Eloquent\Model;

class DemotionRequest extends Model{
    public $timestamps = false;
    protected $table = 'emp_demotion_request';

    protected $fillable = ['id',
        'sub_emp_number',
        'sup_emp_number',
        'demo_status', // Status Request Demotion 1 - Requested, 2 - Approved, 3 - HRD Approved
        'demo_reason',
        'demo_from_level',
        'demo_to_level',
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
    public function demotion_type(){
        return $this->belongsTo('App\Models\Promotions\PromotionType', 'demo_type', 'id');
    }
    public function demotion_status(){
        return $this->belongsTo('App\Models\Promotions\PunishmentStatus', 'demo_status', 'id');
    }
    public function level_from(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'demo_from_level', 'id');
    }
    public function level_to(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'demo_to_level', 'id');
    }
}
