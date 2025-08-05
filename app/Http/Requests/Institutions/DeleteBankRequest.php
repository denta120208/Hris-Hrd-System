<?php

namespace App\Http\Requests\Institutions;

use App\Http\Requests\Request;
use Session, Log;

class DeleteBankRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $sess = explode(',', Session::get('perms'));
        if(in_array("10", $sess)):
            return true;
        else:
            return false;
        endif;
    }

    public function forbiddenResponse() {
        Log::error('================DELETE Bank Request===================');
        Log::error('User ' . Session::get('name'));
        Log::error('======================================================');

        return redirect()->back()->withErrors([
            'error' => 'Forbidden Access, Please Contact Administrator.'
        ]);
    }
    public function rules()
    {
        return [
            //
        ];
    }
}
