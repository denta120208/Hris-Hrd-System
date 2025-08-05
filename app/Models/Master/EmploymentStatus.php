<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model{
    public $timestamps = false;
    protected $table = 'employment_status';

    protected $fillable = ['id','name'];
}
