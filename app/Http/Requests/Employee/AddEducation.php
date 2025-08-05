<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\Request;

class AddEducation extends Request{
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
            'institute' => ['required'],
            'major' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'institute.required' => 'Institute is Required',
            'major.required' => 'Major is Required',
            'start_date.required' => 'Start date is Required',
            'end_date.required' => 'End date is Required'
        ];
    }
}
