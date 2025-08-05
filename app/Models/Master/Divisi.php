<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    public $timestamps = false;
    protected $table = 'job_category';
    protected $fillable = ['id','pnum', 'name','is_delete'];
}
