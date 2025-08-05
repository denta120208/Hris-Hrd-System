<?php

namespace App\Http\Requests\Holiday;

use App\Http\Requests\Request;

class Holiday extends Request{
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
            'description' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'date.required' => 'Date is Required',
            'description.required' => 'Description is Required'
        ];
    }
}
