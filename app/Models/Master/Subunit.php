<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Subunit extends Model{
    public $timestamps = false;
    protected $table = 'subunit';

    protected $fillable = ['id', 'name', 'unit_id', 'description','lft','rgt','level','old_id'];
}
