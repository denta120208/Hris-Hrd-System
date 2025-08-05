<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;
use Session;

class UpdateProjectRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("6", $sess)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'code' => ['required'],
            'seq' => ['required']
        ];   
    }
}
