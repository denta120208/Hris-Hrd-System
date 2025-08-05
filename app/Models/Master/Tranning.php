<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Tranning extends Model
{
    public $timestamps = false;
    protected $table = 'tranning';

    protected $fillable = ['name'];
}
