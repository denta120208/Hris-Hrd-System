<?php

namespace App\Http\Requests\HRD\Employee;

use App\Http\Requests\Request;

class AddEmployeeDW extends Request{
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
            'name' => ['required'],
            'title' => ['required', 'unique:employee,employee_id']
        ];
    }
    public function messages()
    {
        return [
            'name' => 'Employee name is Required',
            'title.required' => 'NIK is Required',
            'title.unique' => 'NIK has already been taken'
        ];
    }
}
