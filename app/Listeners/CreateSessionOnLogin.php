<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Session, Log;

class CreateSessionOnLogin{
    public function handle($user, $remember){
        Session::put([
            'userid' => $user->id,
             'username' => $user->username,
//            'username' => $user->emp_number,
            'nik' => $user->emp_number,
            'name' => $user->name,
            'email' => $user->email,
            'logined' => TRUE,
            'project' => $user->project_code,
            'pnum' => $user->pnum,
            'ptype' => $user->ptype,
            'perms' => $user->permission,
            'is_manage' => $user->is_manage
        ]);
        Log::info('User Login '.$user->name);
    }
}