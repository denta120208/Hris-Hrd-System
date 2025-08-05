<?php

namespace App\Http\Requests\Tenants;

use App\Http\Requests\Request;
use Session, Log;

class StoreTenantCategoryRequest extends Request
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
        return [
            'name' => ['required'],
        ];
    }
}
