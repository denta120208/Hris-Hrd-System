<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model{
    public $timestamps = false;
    protected $table = 'holiday';

    protected $fillable = [
        'description','date','recurring','length','to_date','operational_country_id','holiday_id'
    ];
}
