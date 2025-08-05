<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model{
    public $timestamps = false;
    protected $table = 'job_level_title';

    protected $fillable = ['id',
        'job_level_title',
        'job_description',
        'note',
        'is_deleted',
        'old_id'];
}
