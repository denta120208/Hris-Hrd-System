<?php

namespace App\Http\Requests\HRD\Employee;

use App\Http\Requests\Request;

class AddIntern extends Request{
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
            'emp_firstname' => ['required'],
            'emp_lastname' => ['required'],
            'employee_id' => ['required', 'unique:employee,employee_id'],
            'eeo_cat_code' => ['required'],
            // 'employment_status_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'emp_firstname.required' => 'Employee Firstname is Required',
            'emp_lastname.required' => 'Lastname is Required',
            'employee_id.required' => 'NIK is Required',
            'employee_id.unique' => 'NIK has already been taken',
            'eeo_cat_code.required' => 'Divisi is Required',
            // 'employment_status_id.required' => 'Status is Required'
        ];
    }
}
