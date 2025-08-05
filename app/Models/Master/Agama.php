<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    public $timestamps = false;
    protected $table = 'emp_agama';
    protected $fillable = ['id', 'name'];
}
