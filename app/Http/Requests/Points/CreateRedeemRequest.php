<?php

namespace App\Http\Requests\Points;

use App\Http\Requests\Request;
use Session, Log;

class CreateRedeemRequest extends Request
{
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("13", $sess)):
            return true;
        else:
            return false;
        endif;
    }
    
    public function forbiddenResponse() {
        return redirect()->back()->withErrors([
            'error' => 'Forbidden Access, Please Contact Administrator.'
        ]);
    }
    public function rules()
    {
        return [
            'card_no' => ['required', 'exists:member,card_no,status,1'],
        ];
    }
    public function messages()
    {
        return [
            'card_no.required' => 'Metland Card Number required',
            'card_no.exists' => 'Metland Card Number not active'
        ];
    }
}
