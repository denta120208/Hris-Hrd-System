<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model{
    public $timestamps = false;
    protected $table = 'leave_type';

    protected $fillable = ['id', 'name', 'comIjin', 'is_active'];
}
