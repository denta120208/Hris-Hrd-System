<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class ComDept extends Model
{
    protected $connection = 'websen';
    public $timestamps = false;
    protected $table = 'com_master_departemen';
}
