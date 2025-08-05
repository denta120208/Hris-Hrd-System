<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Localtion extends Model{
    public $timestamps = false;
    protected $table = 'location';

    protected $fillable = ['id', 'name', 'unit_id', 'description', 'companny','lft','rgt','level','old_id'];
}
