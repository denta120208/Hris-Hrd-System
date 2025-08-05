<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{
    public $timestamps = false;
    protected $table = 'employee';

    protected $fillable = ['emp_number','employee_id','badgenumber',
            'emp_lastname',
            'emp_firstname',
            'emp_middle_name',
            'emp_nick_name',
            'emp_smoker',
            'ethnic_race_code',
            'emp_birthday',
            'nation_code',
            'emp_gender',
            'emp_marital_status',
            'emp_ssn_num',
            'emp_sin_num',
            'emp_other_id',
            'emp_dri_lice_num',
            'emp_dri_lice_exp_date',
            'emp_military_service',
            'emp_status',
            'job_title_code',
            'eeo_cat_code',
            'job_dept_id',
            'work_station',
            'emp_street1',
            'emp_street2',
            'city_code',
            'coun_code',
            'provin_code',
            'emp_zipcode',
            'city_code_res',
//            'coun_code_res',
            'provin_code_res',
            'emp_zipcode_res',
            'emp_hm_telephone',
            'emp_mobile',
            'emp_work_telephone',
            'emp_work_email',
            'sal_grd_code',
            'joined_date',
            'emp_oth_email',
            'termination_id',
            'npwp',
            'status_pajak',
            'job_level',
            'custom4',
            'bpjs_ks',
            'bpjs_tk',
            'custom7',
            'custom9',
            'emp_mobile2',
            'location_id',
            'emp_number_old',
            'days_type',
            'emp_facebook',
            'emp_twitter',
            'emp_instagram',
        'dept_id',
        'pnum',
        'ptype',
        'job_dept_id'];
    public function job_title(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'job_title_code', 'id');
    }
    public function job_level(){
        return $this->belongsTo('App\Models\Master\JobTitle', 'job_level_code', 'id');
    }
    public function country(){
        return $this->belongsTo('App\Models\Master\JobMaster', 'job_title_code', 'old_id');
    }
    public function estatus(){
        return $this->belongsTo('App\Models\Master\EmploymentStatus', 'emp_status', 'id');
    }
    public function location(){
        return $this->belongsTo('App\Models\Master\Location', 'location_id', 'id');
    }
    public function emp_dept(){
        return $this->belongsTo('App\Models\Employee\EmpDept', 'dept_id', 'id');
    }
//    public function job_title(){
//        return $this->belongsTo('App\Models\Master\JobMaster', 'job_title_code', 'old_id');
//    }
}
