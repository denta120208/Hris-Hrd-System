<?php

namespace App\Http\Requests\Members;

use App\Http\Requests\Request, Session;

class StoreMemberRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("8", $sess)):
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
            'first_name' => ['required'],
            'email' => ['required', 'email'],
            'hp_tlp' => ['required', 'numeric'],
            'member_type' => ['required'],
            'card_type' => ['required'],
            'emoney' => ['required_if:card_type,2', 'numeric', 'unique:member,emoney'],
            'company_name' => ['required_if:booker,true'],
            'company_tlp' => ['required_if:booker,true'],
            'company_add' => ['required_if:booker,true'],
            'ktp' => ['unique:member,ktp'],
            'religion' => ['required'],
            'ktp' => ['required'],
            'uploadKTP' => ['image', 'mimes:jpeg,png']
        ];//required_if:anotherfield,value
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First Name is Required',
            'email.required' => 'Email is Required',
            'email.email' => 'Email field should valid email',
            'hp_tlp.required' => 'No Hp/Telp is Required',
            'member_type.required' => 'Member Type cannot empty',
            'card_type.required' => 'Card Type cannot empty',
            'emoney.required' => 'E-Money Number is Required',
            'emoney.numeric' => 'E-Money Number should be Number Only',
            'company_name.required_if' => 'Company Name is Required as Booker',
            'company_tlp.required_if' => 'Company Phone is Required as Booker',
            'company_add.required_if' => 'Company Address is Required as Booker',
            'religion.required' => 'Religion is Required',
//            'uploadKTP.required' => 'Upload KTP is Required',
            'ktp.required' => 'KTP is Required'
        ];
    }
}
