<?php

namespace App\Http\Requests\PointFormulas;

use App\Http\Requests\Request, Session;

class StorePFRequest extends Request
{
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("11", $sess)):
            return true;
        else:
            return false;
        endif;
    }
    
    public function rules()
    {
        return [
            'desc' => 'required',
            'point_type' => 'required',
            'point_amount' => 'required|numeric',
            'point_value' => 'required|numeric',
            'point_amount_max' => 'required|numeric',
            'point_frdate' => 'required',
            'point_todate' => 'required|after:point_frdate'
        ];
    }
    public function messages()
    {
        return [
            'desc.required' => 'Description field is Required',
            'point_type.required' => 'Please chose Point Type',
            'point_amount.required' => 'Amount field is Required',
            'point_amount.numeric' => 'Amount field must Numeric only',
            'point_value.required' => 'Point field is Required',
            'point_value.numeric' => 'Point field must Numeric only',
            'point_amount_max.required' => 'Point Amount Max field is Required',
            'point_amount_max.numeric' => 'Point Amount Max field must Numeric only',
            'point_frdate.required' => 'Valid Point Date Start is Required',
            'point_todate.required' => 'Valid Point Date End is Required',
            'point_todate.after' => 'Valid Point Date End must Greater than Valid Point Date Start'
        ];
    }
}
