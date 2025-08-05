<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Model;

class Email extends Model{
    public $timestamps = false;
    protected $table = 'email_config';

    protected $fillable = ['id','name_conf','subject_conf','from_conf','body_conf',
        'created_at','created_by','updated_at','updated_by'];
}
