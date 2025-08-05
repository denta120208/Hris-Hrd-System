<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AppraisalType extends Model{
    public $timestamps = false;
    protected $table = 'appraisal_type';

    protected $fillable = ['name','code_appraisal','created_at','created_by'];

}
