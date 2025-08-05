<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAttachment extends Model{
    public $timestamps = false;
    protected $table = 'emp_attachment';

    protected $fillable = ['emp_number','eattach_filename','eattach_size','eattach_attachment','eattach_type','attached_by','attached_by_name','attached_time','screen'];

}
