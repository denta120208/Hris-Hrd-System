<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateReadingAct extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_readingAct';

    protected $fillable = [
        'candidate_id','topics','grade'
    ];
}
