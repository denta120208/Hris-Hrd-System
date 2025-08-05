<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class TemplateContract extends Model{
    public $timestamps = false;
    protected $table = 'template_contract';

    protected $fillable = ['id', 'name', 'file_temp', 'status'];
}
