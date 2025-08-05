<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\Request;

class UnterminationReqeust extends Request
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
            'note' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'note.required' => 'Notes is Required',
        ];
    }
}
