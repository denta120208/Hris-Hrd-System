<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $table = 'country';
    protected $fillable = ['id','cou_code','name','cou_name','iso3','numcode'];
}
