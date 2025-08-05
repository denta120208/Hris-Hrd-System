<?php

namespace App\Models\Appraisal;

use Illuminate\Database\Eloquent\Model;

class AprraisalResult extends Model{
    public $timestamps = false;
    protected $table = 'appraisal_result';

    protected $fillable = ['emp_number','id','min_val','max_val','alpha_val','created_at','created_by','updated_at','updated_by'];
}
