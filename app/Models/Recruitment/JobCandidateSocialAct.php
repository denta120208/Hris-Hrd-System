<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateSocialAct extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_socialAct';

    protected $fillable = [
        'candidate_id','organisation_name','activities','position','years'
    ];
}
