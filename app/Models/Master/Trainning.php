<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Trainning extends Model
{
    public $timestamps = false;
    protected $table = 'trainning';

    protected $fillable = ['name'];
}
