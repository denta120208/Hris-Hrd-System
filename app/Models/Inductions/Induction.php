<?php

namespace App\Models\Inductions;

use Illuminate\Database\Eloquent\Model;

class Induction extends Model{
    public $timestamps = false;
    protected $table = 'induction_trainning';

    protected $fillable = ['id','name','url_gform','status','project_code','pnum','ptype','created_at','created_by','updated_at','updated_by'];

}