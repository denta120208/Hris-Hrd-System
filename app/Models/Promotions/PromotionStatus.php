<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Model;

class PromotionStatus extends Model{
    public $timestamps = false;
    protected $table = 'promotion_status';

    protected $fillable = ['id','name'];
}
