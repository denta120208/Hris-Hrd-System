<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LBARequest extends Request
{
    
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'card_no' => ['required', 'unique:mysql2.lba,card_no', 'min:16'],
            'name' => ['required'],
            'dob' => ['required']
        ];
    }
    
    public function messages()
    {
        return [
            'card_no.required' => 'Metland Card Number is Required',
            'card_no.unique' => 'Metland Card Number has already been Registered',
            'card_no.min' => 'Metland Card Number needs to be valid',
            'name.required' => 'Customer Name is Required',
            'dob.required' => 'Customer Date of Birth is Required'
        ];
    }
}
