<?php

namespace App\Http\Requests\HRD\Attendance;

use App\Http\Requests\Request;

class setAttLeave extends Request{
    protected $redirectRoute = "hrd.inout";
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
            'date' => ['required'],
            'reason' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'date.required' => 'Date is Required',
            'reason.required' => 'Reason is Required'
        ];
    }
}
