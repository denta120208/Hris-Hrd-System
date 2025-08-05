<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model{
    protected $connection = 'websen';
    public $timestamps = false;
    protected $table = 'com_absensi_inout';

}
