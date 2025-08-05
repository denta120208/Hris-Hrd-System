<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Dependents extends Model
{
    public $timestamps = false;
    protected $table = 'emp_dependents';

    protected $fillable = [
        'emp_number',
        'ed_seqno',
        'ed_name',
        'ed_relationship',
        'ed_relationship_type',
        'ed_date_of_birth',
        'is_delete'
    ];
}
