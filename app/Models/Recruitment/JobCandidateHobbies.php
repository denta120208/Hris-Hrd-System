<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateHobbies extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_hobbies';

    protected $fillable = [
        'candidate_id','hobby'
    ];
}
