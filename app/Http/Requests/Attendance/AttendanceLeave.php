<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\Request;

class AttendanceLeave extends Request{
    public function authorize()
    {
//        $sess = explode(',', Session::get('perms'));
//        if(in_array("8", $sess) && Session::get('is_manage') == TRUE):
            return true;
//        else:
//            return false;
//        endif;
    }
    public function forbiddenResponse() {
        return redirect()->back()->withErrors([
            'error' => 'Forbidden Access, Please Contact Administrator.'
        ]);
    }
    public function rules(){
        return [
            'start_date' => ['required'],
            'reason' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'start_date.required' => 'Date is Required',
            'reason.required' => 'Reason is Required'
        ];
    }
}
