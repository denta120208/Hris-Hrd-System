<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Appraisal9Box extends Model{
    public $timestamps = false;
    protected $table = 'appraisal_9_box';

    protected $fillable = ['id','name','app_code','keterangan','val_9_box','created_at','updated_at','updated_by'];
}
