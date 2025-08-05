<?php

namespace App\Http\Requests\Institutions;

use App\Http\Requests\Request;
use Session, Log;

class InstitutionCreate extends Request
{
    public function authorize()
    {
//        $sess = explode(',', Session::get('perms'));
//        if(in_array("12", $sess)):
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
    public function rules()
    {
        return [
            'vendor_name' => ['required'],
            'vendor_tlp' => ['numeric'],
            'vendor_fax' => ['numeric'],
            'vendor_email' => ['email'],
            'training_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'vendor_name.required' => 'Institutions Name required',
            'vendor_tlp.numeric' => 'Institutions Phone must numeric',
            'vendor_fax.numeric' => 'Institutions Fax must numeric',
            'vendor_email.email' => 'Institutions Email must valid',
            'training_id.required' => 'Training Topic required'
        ];
    }
}
