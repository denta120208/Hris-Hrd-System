<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class JobCandidate extends Model{
    public $timestamps = false;
    protected $table = 'job_candidate';

    protected $fillable = ['id',
        'first_name','middle_name','last_name','email','contact_number','status','address','gender','height','weight','religion','nationality',
        'ktp_no','driving_licence','place_of_birth','dob','maritial_status','picture','pic_height','pic_width','pic_type','facebook','linkedin',
        'twitter','instagram',
    ];
}
