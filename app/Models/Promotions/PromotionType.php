<?php

namespace App\Models\Mutations;

use Illuminate\Database\Eloquent\Model;

class PromotionType extends Model{
    public $timestamps = false;
    protected $table = 'promotion_type';

    protected $fillable = ['id','name'];

}
