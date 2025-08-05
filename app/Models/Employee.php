<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'hs_hr_employee';
    protected $primaryKey = 'emp_number';
    
    protected $fillable = [
        'emp_number',
        'employee_id',
        'emp_firstname',
        'emp_middle_name',
        'emp_lastname',
        'emp_status',
        'join_date',
        'termination_date'
    ];

    public function documents()
    {
        return $this->hasMany(AdministrationDocument::class, 'emp_number', 'emp_number');
    }

    public function getFullNameAttribute()
    {
        return trim($this->emp_firstname . ' ' . $this->emp_middle_name . ' ' . $this->emp_lastname);
    }
} 