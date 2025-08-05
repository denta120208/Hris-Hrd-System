<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Model;

class PromotionRquest extends Model{
    public $timestamps = false;
    protected $table = 'emp_promotion_request';

    protected $fillable = ['id',
        'sub_emp_number',
        'sup_emp_number',
        'pro_status', // Status Request Mutasi 1 - Requested, 2 - Approved, 3 - HRD Approved
        'pro_reason',
        'pro_from_level',
        'pro_to_level',
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
    public function promotion_type(){
        return $this->belongsTo('App\Models\Promotions\PromotionType', 'pro_type', 'id');
    }
    public function promotion_status(){
        return $this->belongsTo('App\Models\Promotions\PromotionStatus', 'pro_status', 'id');
    }
    public function level_from(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'pro_from_level', 'id');
    }
    public function level_to(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'pro_to_level', 'id');
    }
}
