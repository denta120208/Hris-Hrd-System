<?php

namespace App\Models\Punishments;

use Illuminate\Database\Eloquent\Model;

class PunishmentRquest extends Model{
    public $timestamps = false;
    protected $table = 'emp_punishment_request';

    protected $fillable = ['id',
        'sub_emp_number',
        'sup_emp_number',
        'emp_id',
        'punish_status', // Status Request Mutasi 1 - Requested, 2 - Approved, 3 - HRD Approved
        'punish_reason',
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
    public function punishment_type(){
        return $this->belongsTo('App\Models\Punishments\PunishmentType', 'punish_type', 'id');
    }
    public function punishment_status(){
        return $this->belongsTo('App\Models\Punishments\PunishmentStatus', 'punish_status', 'id');
    }
//    public function level_from(){
//        return $this->belongsTo('App\Models\Master\JobMaster', 'pro_from_level', 'id');
//    }
//    public function level_to(){
//        return $this->belongsTo('App\Models\Master\JobMaster', 'pro_to_level', 'id');
//    }
}
