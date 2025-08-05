<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeDW extends Model{
    public $timestamps = false;
    protected $connection ='adms';
    protected $table = 'userinfo';

    protected $fillable = ['userid',
            'name',
            'badgenumber',
            'title',
            'SN',
            'minzu',
            'defaultdeptid'];
}
