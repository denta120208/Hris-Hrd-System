<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationDocument extends Model
{
    protected $table = 'administration_documents';
    
    protected $fillable = [
        'emp_number',
        'document_type',
        'document_content',
        'created_at',
        'updated_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_number', 'emp_number');
    }
} 