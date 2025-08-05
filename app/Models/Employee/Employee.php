<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'emp_number',
        'employee_id',
        'emp_firstname',
        'emp_middle_name',
        'emp_lastname',
        'emp_nick_name',
        'emp_smoker',
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
        'work_station',
        'emp_street1',
        'emp_street2',
        'city_code',
        'coun_code',
        'provin_code',
        'emp_zipcode',
        'emp_hm_telephone',
        'emp_mobile',
        'emp_work_telephone',
        'emp_work_email',
        'sal_grd_code',
        'joined_date',
        'emp_oth_email',
        'termination_id',
        'custom1',
        'custom2',
        'custom3',
        'custom4',
        'custom5',
        'custom6',
        'custom7',
        'custom8',
        'custom9',
        'custom10',
        'surat_berakhir_hubungan_kerja',
        'surat_menjaga_rahasia',
        'surat_perintah_kerja',
        'surat_kontrak_kerja'
    ];
} 