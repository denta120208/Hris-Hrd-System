<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateEducation extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_educations';

    protected $fillable = [
        'candidate_id','institute','major','start_date','end_date','degree','score'
    ];
}
