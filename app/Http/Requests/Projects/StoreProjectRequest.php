<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;
use Session;

class StoreProjectRequest extends Request
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

    public function forbiddenResponse() {
        return redirect()->back()->withErrors([
            'error' => 'Forbidden Access, Please Contact Administrator.'
        ]);
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
            'project_code' => ['required', 'alpha', 'size:2'],
            'code' => ['required', 'numeric', 'digits:4'],
            'seq' => ['required', 'numeric', 'digits:2']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The Project Name is Required',
            'code.required' => 'The Project Code is Required',
            'seq.required' => 'The Project Sequence is Required',
            'code.numeric' => 'The Project Code containt only Numeric',
            'seq.numeric' => 'The Project Sequence containt only Numeric',
            'code.digits' => 'The Project Code exact length of 4 digits',
            'seq.digits' => 'The Project Sequence exact length of 2 digits',
            'project_code.size' => 'The Initial Project Name exact length of 2 digits',
            'project_code.required' => 'The Initial Project Name is Required',
            'project_code.alpha' => 'The Initial Project Name containt only Alphabetic Characters.'
        ];
    }
}
