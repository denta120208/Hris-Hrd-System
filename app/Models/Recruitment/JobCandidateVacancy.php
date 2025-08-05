<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateVacancy extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_vacancy';

    protected $fillable = [
        'id','candidate_id','vacancy_id','status','applied_date'
    ];

    public function job_vacancy(){
        return $this->belongsTo('App\Models\Recruitment\JobVacancy', 'vacancy_id', 'id');
    }
    public function job_candidate(){
        return $this->belongsTo('App\Models\Recruitment\JobCandidate', 'candidate_id', 'id');
    }
}
