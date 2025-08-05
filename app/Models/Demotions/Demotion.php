<?php

namespace App\Models\Demotions;

use Illuminate\Database\Eloquent\Model;

class Demotion extends Model{
    public $timestamps = false;
    protected $table = 'emp_demotion';

    protected $fillable = ['id',
        'demo_request_id',
        'demo_doc_no',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    public function demotion_requst(){
        return $this->belongsTo('App\Models\Demotions\DemotionRequest', 'demo_request_id', 'id');
    }
}
