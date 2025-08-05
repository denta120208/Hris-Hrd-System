<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateNewsMagz extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_news_magz';

    protected $fillable = [
        'candidate_id','newspaper','magazine'
    ];
}
