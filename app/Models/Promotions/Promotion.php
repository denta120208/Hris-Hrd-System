<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model{
    public $timestamps = false;
    protected $table = 'emp_promotion';

    protected $fillable = ['id',
        'pro_request_id',
        'pro_doc_no',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    public function promotion_requst(){
        return $this->belongsTo('App\Models\Promotions\PromotionRequest', 'pro_request_id', 'id');
    }
}
