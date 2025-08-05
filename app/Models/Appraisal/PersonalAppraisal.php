<?php

namespace App\Models\Appraisal;

use App\Libraries\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class PersonalAppraisal extends Model{
    use Encryptable;
    protected $encryptable = [
        'nilai_awal',
        'nilai_akhir',
        'pa_kategori',
        'minus',
        'kategori_akum',
        'kategori_kotak'
    ];
    public $timestamps = false;
    protected $table = 'personal_appraisal';

    protected $fillable = ['employee_id','thn_pa','created_at','created_by'];
}
