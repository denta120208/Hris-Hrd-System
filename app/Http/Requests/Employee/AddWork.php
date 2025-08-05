<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\Request;

class AddWork extends Request{
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
            'eexp_employer' => ['required'],
            'eexp_jobtit' => ['required'],
            'eexp_from_date' => ['required'],
            'eexp_to_date' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'eexp_employer.required' => 'Institute is Required',
            'eexp_jobtit.required' => 'Major is Required',
            'eexp_from_date.required' => 'Start date is Required',
            'eexp_to_date.required' => 'End date is Required'
        ];
    }
}
