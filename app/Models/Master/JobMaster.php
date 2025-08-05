<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model{
    public $timestamps = false;
    protected $table = 'job_title';

    protected $fillable = [
        'id',
        'job_title',
        'job_description',
        'note',
        'is_deleted',
        'old_id'];

}
