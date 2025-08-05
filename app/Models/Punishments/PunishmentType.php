<?php

namespace App\Models\Punishments;

use Illuminate\Database\Eloquent\Model;

class PunishmentType extends Model{
    public $timestamps = false;
    protected $table = 'punishment_type';

    protected $fillable = ['id','name', 'descs'];

}
