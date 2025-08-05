<?php
namespace App\Models\Menus;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model{
    public $timestamps = false;
    protected $table = 'menus';

    protected $fillable = ['id','title','uri','parent_id','is_parent',
        'show_menu','manage_status','icon'];
}