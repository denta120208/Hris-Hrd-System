<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    public $timestamps = false;
    protected $table = 'job_department';
    protected $fillable = ['id', 'job_dept_desc'];
}
