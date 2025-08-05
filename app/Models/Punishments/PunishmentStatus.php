<?php

namespace App\Models\Punishments;

use Illuminate\Database\Eloquent\Model;

class PunishmentStatus extends Model{
    public $timestamps = false;
    protected $table = 'punishment_status';

    protected $fillable = ['id','name'];
}
