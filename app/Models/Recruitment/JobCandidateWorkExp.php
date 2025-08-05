<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateWorkExp extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_work_experience';

    protected $fillable = [
        'candidate_id','name','position','total_employee','superior_name','work_from','work_to','salary','reason','job_desk','structure_organisation'
    ];
}
