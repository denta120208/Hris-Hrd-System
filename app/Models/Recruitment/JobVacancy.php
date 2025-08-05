<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model{
    public $timestamps = false;
    protected $table = 'job_vacancy';

    protected $fillable = ['id',
        'job_title_code','hrd_id','name','description','no_of_positions','vacancy_status','published_in_feed','created_at','created_by','updated_at',
        'dept_id', 'location_id'
    ];

    public function job_title(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'job_title_code', 'id');
    }
    public function job_location(){
        return $this->belongsTo('App\Models\Master\Location', 'location_id', 'id');
    }
}
