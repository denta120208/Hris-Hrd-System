<?php

namespace App\Http\Requests\Points;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Http\Requests\Request;
use Session, DB;

class StoreRedeemRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory) {

        $validationFactory->extend(
                'foo', function ($attribute, $value, $parameters) {
            return 'foo' === $value;
        }, 'Sorry, it failed foo validation!'
        );
    }

    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("13", $sess)):
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
//            'name' => ['required'],
//            'username' => ['required', 'unique:users,username'],
//            'email' => ['required', 'email', 'unique:users,email'],
//            'password' => ['required', 'confirmed']
        ];
    }
    public function messages()
    {
        return [
//            'name' => ['required'],
//            'username' => ['required', 'unique:users,username'],
//            'email' => ['required', 'email', 'unique:users,email'],
//            'password' => ['required', 'confirmed']
        ];
    }
}
