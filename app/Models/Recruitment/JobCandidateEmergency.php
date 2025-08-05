<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateEmergency extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_emergency';

    protected $fillable = [
        'candidate_id','ec_name','ec_addr','ec_phone','ec_relationship'
    ];
}
