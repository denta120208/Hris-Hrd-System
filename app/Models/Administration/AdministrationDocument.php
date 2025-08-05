<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class AdministrationDocument extends Model
{
    protected $table = 'administration_documents';
    
    protected $fillable = [
        'employee_id',
        'document_type',
        'content',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_number');
    }
} 