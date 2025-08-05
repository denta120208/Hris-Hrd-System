<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'location';
    protected $fillable = ['name', 'country_code', 'province', 'city', 'address', 'zip_code', 'phone', 'fax', 'notes', 'pnum', 'ptype', 'code'];
}
