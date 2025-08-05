<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AppraisalValue extends Model{
    public $timestamps = false;
    protected $table = 'appraisal_value';

    protected $fillable = ['appraisal_id','value_name','low_value','high_value','appraisal_type','created_at','created_by','updated_at','updated_by'];

}
