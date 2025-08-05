<?php

namespace App\Models\Mutations;

use Illuminate\Database\Eloquent\Model;

class MutationType extends Model{
    public $timestamps = false;
    protected $table = 'mutation_type';

    protected $fillable = ['id','name'];

}
