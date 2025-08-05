<?php

namespace App\Http\Requests\Tenants;

use App\Http\Requests\Request;
use Session;

class UpdateTenantRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("7", $sess)):
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
        if(Session::get('project') == 'HO'){
            return [
                'name' => ['required'],
                'tc_id' => ['required'],
                'pic' => ['required'],
                'tlp' => ['required', 'numeric'],
                'project_code' => ['required'],
                'loc' => ['required'],
            ];
        }else{
            if(Session::get('pnum') == '1802'):
                return [
                    'name' => ['required'],
                'tc_id' => ['required'],
                    'loc' => ['required'],
                ];
            else:
               return [
                    'name' => ['required'],
                'tc_id' => ['required'],
                    'pic' => ['required'],
                    'tlp' => ['required', 'numeric'],
                    'loc' => ['required'],
                ]; 
            endif;
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'Tenant Name is Required',
            'pic.required' => 'Tenant PIC Name is Required',
            'tc_id.required' => 'Tenant Category is Required',
            'tlp.required' => 'Tenant Telephone Number is Required',
            'pic.alpha' => 'Tenant PIC Name containt only Alphabetic Characters',
            'tlp.numeric' => 'Tenant Telephone Number containt only Numeric',
            'loc.required' => 'Tenant Location is Required',
            'project_code.required' => 'Tenant Project Name is Required'
        ];
    }
}
