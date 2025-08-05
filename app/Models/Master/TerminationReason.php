<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class TerminationReason extends Model{
    public $timestamps = false;
    protected $table = 'termination_reason';

    protected $fillable = ['id','name'];
}
