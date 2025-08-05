<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    public $timestamps = false;
    protected $table = 'job_category';

    protected $fillable = [
        'id',
        'name'];
}
