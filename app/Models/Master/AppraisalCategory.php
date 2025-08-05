<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AppraisalCategory extends Model{
    public $timestamps = false;
    protected $table = 'appraisal_category';

    protected $fillable = ['name_appraisal','created_at','created_by','updated_at','update_by'];

}
