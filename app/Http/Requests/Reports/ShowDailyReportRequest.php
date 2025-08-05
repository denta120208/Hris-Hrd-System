<?php

namespace App\Http\Requests\Reports;

use App\Http\Requests\Request, Session;

class ShowDailyReportRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       $sess = explode(',', Session::get('perms'));
        if(in_array("14", $sess)):
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
            'card_no' => ['required']
        ];
    }
}
