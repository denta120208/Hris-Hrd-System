<?php

namespace App\Models\Punishments;

use Illuminate\Database\Eloquent\Model;

class Punishment extends Model{
    public $timestamps = false;
    protected $table = 'emp_punishment';

    protected $fillable = ['id',
        'punish_request_id',
        'punish_doc_no',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    public function promotion_requst(){
        return $this->belongsTo('App\Models\Punishments\PunishmentRequest', 'punish_request_id', 'id');
    }
}
