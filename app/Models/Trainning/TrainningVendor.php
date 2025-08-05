<?php

namespace App\Models\Trainning;

use Illuminate\Database\Eloquent\Model;

class TrainningVendor extends Model
{
    public $timestamps = false;
    protected $table = 'trainning_vendor';
    protected $fillable = [
        'id','training_id','vendor_name','vendor_addr','vendor_tlp','vendor_fax','vendor_email'
    ];
}
