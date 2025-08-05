<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidateLanguage extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate_languages';

    protected $fillable = [
        'language_id','candidate_id','listening_grade','reading_grade','writting_grade','speaking_grade'
    ];
}
