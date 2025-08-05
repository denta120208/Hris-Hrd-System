<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model{
    public $timestamps = false;
    protected $table = 'holiday_type';

    protected $fillable = [
        'holiday_type'
    ];

}
