<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveStatus extends Model{
    public $timestamps = false;
    protected $table = 'leave_status';
    protected $fillable = ['id','status','name'];
}
