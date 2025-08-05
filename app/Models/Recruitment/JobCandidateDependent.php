<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateDependent extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_dependents';

    protected $fillable = [
        'candidate_id','name','relationship','gender','umur','education','employment','remarks'
    ];
}
