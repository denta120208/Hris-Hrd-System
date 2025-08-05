<?php

namespace App\Models\OverTime;

use Illuminate\Database\Eloquent\Model;

class OverTimeStatus extends Model{
    public $timestamps = false;
    protected $table = 'overtime_status';

    protected $fillable = ['id','name'];
}
