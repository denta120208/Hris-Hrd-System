<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;
use Session;

class UpdateProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Session::get('userid') == auth()->user()->id):
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
            'name' => ['required'],
            'email' => ['email'],
            'password' => ['required_with:password_confirmation', 'confirmed']
        ];
    }
}
