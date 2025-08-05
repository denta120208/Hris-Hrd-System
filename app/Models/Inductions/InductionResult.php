<?php

namespace App\Models\Inductions;

use Illuminate\Database\Eloquent\Model;

class InductionResult extends Model{
    public $timestamps = false;
    protected $table = 'induction_result';

    protected $fillable = ['id','id_induction','employee_id','result','created_at','created_by'];
    
}