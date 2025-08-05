<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    public $timestamps = false;
    protected $table = 'emp_emergency_contacts';

    protected $fillable = [
        'emp_number',
        'emp_number_old',
        'eec_seqno',
        'eec_name',
        'eec_relationship',
        'eec_home_no',
        'eec_mobile_no',
        'eec_office_no'
    ];
}
