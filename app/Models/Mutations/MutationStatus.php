<?php

namespace App\Models\Mutations;

use Illuminate\Database\Eloquent\Model;

class MutationStatus extends Model{
    public $timestamps = false;
    protected $table = 'mutation_status';

    protected $fillable = ['id','name'];
}
