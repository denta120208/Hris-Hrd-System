<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model{
    public $timestamps = false;
    protected $table = 'appraisal';

    protected $fillable = ['factor','appraisal_cat','tips_kurang','tips_cukup','tips_cb','tips_baik','tips_sb','created_at','updated_at','updated_by'];

}
