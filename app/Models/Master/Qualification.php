<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    public $timestamps = false;
    protected $table = 'emp_work_experience';

    protected $fillable = ['id','emp_number','eexp_seqno','eexp_employer','eexp_jobtit','eexp_from_date','eexp_to_date','eexp_comments','eexp_internal','is_delete'];
}
