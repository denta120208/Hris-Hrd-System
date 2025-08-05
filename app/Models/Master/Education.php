<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Education extends Model{
    public $timestamps = false;
    protected $table = 'education';

    protected $fillable = ['id','name'];
}
