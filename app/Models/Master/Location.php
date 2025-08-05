<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Location extends Model{
    public $timestamps = false;
    protected $table = 'location';

    protected $fillable = ['id', 'adms_dept_id', 'name', 'old_id','country_code', 'province','city','address',
      'zip_code','phone','fax','notes','pnum','ptype','code','companny','is_active'];
}
