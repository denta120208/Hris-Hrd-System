<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class PayrollEmp extends Model{
    protected $connection = 'payroll';
    public $timestamps = false;
    protected $table = 'employee';

    protected $fillable = [
        'id',
        'emp_id',
        'emp_name',
        'emp_lvl',
        'emp_absen_name',
        'emp_status', 'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'emp_dept',
        'emp_tgl_masuk',
        'emp_tgl_lahir',
        'emp_status_karyawan',
        'emp_status_pernikahan',
        'emp_npwp',
        'project',
        'emp_ktp',
        'tnj_harian',
        'emp_email'
    ];

}
