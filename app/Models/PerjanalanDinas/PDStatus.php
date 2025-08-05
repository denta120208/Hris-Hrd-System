<?php

namespace App\Models\PerjanalanDinas;

use Illuminate\Database\Eloquent\Model;

class PDStatus extends Model{
    public $timestamps = false;
    protected $table = 'perjalanDinas_status';

    protected $fillable = ['id','name'];
}
