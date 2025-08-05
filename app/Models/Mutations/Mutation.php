<?php

namespace App\Models\Mutations;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model{
    public $timestamps = false;
    protected $table = 'emp_mutation';

    protected $fillable = ['id',
        'mt_request_id',
        'mt_doc_no',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    public function mutation_requst(){
        return $this->belongsTo('App\Models\Mutations\MutationRequest', 'mt_request_id', 'id');
    }
}