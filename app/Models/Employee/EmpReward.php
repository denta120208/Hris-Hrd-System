<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpReward extends Model{
    public $timestamps = false;
    protected $table = 'emp_rewards';

    protected $fillable = ['emp_number','employee_id','rewards_id','year_reward'];

    public function reward_name(){
        return $this->belongsTo('App\Models\Master\Reward', 'rewards_id', 'id');
    }
}
