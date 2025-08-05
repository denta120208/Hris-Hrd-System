<?php

namespace App\Models\Punishments;

use Illuminate\Database\Eloquent\Model;

class PunishmentRequest extends Model{
    public $timestamps = false;
    protected $table = 'emp_punishment_request';

    protected $fillable = [
        'id',
        'sub_emp_number',
        'emp_id',
        'sup_emp_number',
        'punish_type',
        'punish_status',
        'punish_reason',
        'created_at',
        'created_by',
        'updated_at',
        'approved_at',
        'approved_by',
        'hrd_approved_at',
        'hrd_approved_by',
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
}
