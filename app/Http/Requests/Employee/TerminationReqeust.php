<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\Request;

class TerminationReqeust extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'termination_date' => ['required'],
            'reason_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'termination_date.required' => 'Termination Date is Required',
            'reason_id.required' => 'Termination Reason is Required',
        ];
    }
}
