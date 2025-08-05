<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model{
    public $timestamps = false;
    protected $table = 'rewards';

    protected $fillable = ['id', 'name'];
}
