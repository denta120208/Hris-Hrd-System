<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CashbackRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $now = date('Y-m-d');
        return [
            'card_no' => ['required', 'min:5', 'max:16'],
            'name' => ['required'],
            'awl_voc_no' => ['required'],
            'akr_voc_no' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'card_no.required' => 'Metland Card Number is Required',
            'card_no.min' => 'Metland Card Number is Required at least 10 digit',
            'card_no.max' => 'Metland Card Number is Required at least 16 digit',
            'name.required' => 'Customer Name is Required',
            'awl_voc_no.required' => 'Start Voucher No is Required',
            'akr_voc_no.required' => 'End Voucher No is Required'
        ];
    }
}
