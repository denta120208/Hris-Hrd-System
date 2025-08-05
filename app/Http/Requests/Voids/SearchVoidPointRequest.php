<?php

namespace App\Http\Requests\Voids;

use App\Http\Requests\Request;
use Session, Log;

class SearchVoidPointRequest extends Request
{
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("15", $sess)):
            return true;
        else:
            return false;
        endif;
    }
    
    public function forbiddenResponse() {
        Log::error('================Trying Access===================');
        Log::error('A User '.Session::get('name').' has tried access Void Point.');
        Log::error('====================================');
        return redirect()->back()->withErrors([
            'error' => 'Forbidden Access, Please Contact Administrator.'
        ]);
    }
    
    public function rules()
    {
        return [
            'src_field' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'src_field.required' => 'Search Field can not be empty'
        ];
    }
}
