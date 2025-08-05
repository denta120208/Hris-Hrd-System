<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpPromotion extends Model{
    public $timestamps = false;
    protected $table = 'emp_promotions';

    protected $fillable = ['emp_number','promotion_date','promotion_from','promotion_to', 'promo_pnum', 'promo_ptype', 'created_at', 'created_by'];

    public function name(){
        return $this->belongsTo('App\Models\Master\Employee', 'emp_number', 'emp_number');
    }
}
