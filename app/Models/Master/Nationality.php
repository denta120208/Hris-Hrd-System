<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    public $timestamps = false;
    protected $table = 'nationality';
    protected $fillable = ['id', 'name'];
}
